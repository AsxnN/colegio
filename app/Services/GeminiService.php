<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl;
    protected $model;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->baseUrl = config('services.gemini.base_url', 'https://generativelanguage.googleapis.com/v1beta');
        $this->model = config('services.gemini.model', 'gemini-1.5-flash');

        Log::info('🔧 Sistema de IA inicializado', [
            'api_key_presente' => !empty($this->apiKey),
            'base_url' => $this->baseUrl,
            'model' => $this->model
        ]);
    }

    public function verificarConfiguracion(): bool
    {
        if (empty($this->apiKey)) {
            Log::error('❌ Sistema de IA no configurado');
            return false;
        }

        Log::info('✅ Sistema de IA configurado correctamente');
        return true;
    }

    public function testConexion(): array
    {
        if (!$this->verificarConfiguracion()) {
            return [
                'success' => false,
                'message' => 'API Key no configurada'
            ];
        }

        try {
            $response = Http::timeout(30)
                ->post("{$this->baseUrl}/models/{$this->model}:generateContent?key={$this->apiKey}", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => 'Di "Hola"']
                            ]
                        ]
                    ]
                ]);

            if ($response->successful()) {
                Log::info('✅ Conexión exitosa con el sistema de IA');
                return [
                    'success' => true,
                    'message' => 'Conexión exitosa con el sistema de IA'
                ];
            } else {
                Log::error('❌ Error en respuesta del sistema de IA', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return [
                    'success' => false,
                    'message' => 'Error: ' . $response->status()
                ];
            }
        } catch (\Exception $e) {
            Log::error('❌ Excepción al conectar con el sistema de IA', [
                'error' => $e->getMessage()
            ]);
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function generarPrediccion(array $datosEstudiante): array
    {
        Log::info('🎯 Iniciando análisis predictivo con IA', [
            'estudiante' => $datosEstudiante['estudiante']['nombre'] ?? 'N/A'
        ]);

        if (!$this->verificarConfiguracion()) {
            Log::error('❌ No se puede generar predicción: sistema de IA no configurado');
            return $this->respuestaError('Sistema de IA no configurado. Contacte al administrador del sistema.');
        }

        try {
            $prompt = $this->construirPrompt($datosEstudiante);
            
            Log::info('📝 Datos preparados para análisis', [
                'longitud' => strlen($prompt),
                'preview' => substr($prompt, 0, 200) . '...'
            ]);

            $url = "{$this->baseUrl}/models/{$this->model}:generateContent?key={$this->apiKey}";
            
            Log::info('🌐 Enviando datos al sistema de IA', [
                'url' => $url,
                'model' => $this->model
            ]);

            $response = Http::timeout(60)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($url, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'topK' => 40,
                        'topP' => 0.95,
                        'maxOutputTokens' => 2048,
                    ]
                ]);

            Log::info('📦 Respuesta recibida del sistema de IA', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'body_length' => strlen($response->body())
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                
                Log::info('✅ Análisis de IA completado', [
                    'response_data' => $responseData
                ]);
                
                Log::info('🔍 Procesando resultado del análisis', [
                    'tiene_candidates' => isset($responseData['candidates']),
                    'tiene_error' => isset($responseData['error']),
                    'response_keys' => array_keys($responseData),
                    'candidates_count' => isset($responseData['candidates']) ? count($responseData['candidates']) : 0
                ]);

                // Verificar diferentes estructuras posibles de respuesta
                if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                    $textoIA = $responseData['candidates'][0]['content']['parts'][0]['text'];
                    
                    Log::info('📄 Análisis de IA extraído correctamente', [
                        'longitud' => strlen($textoIA),
                        'preview' => substr($textoIA, 0, 300) . '...'
                    ]);

                    return $this->procesarRespuestaIA($textoIA, $datosEstudiante);
                } 
                // Intentar estructura alternativa
                elseif (isset($responseData['candidates'][0]['output'])) {
                    $textoIA = $responseData['candidates'][0]['output'];
                    
                    Log::info('📄 Análisis extraído de estructura alternativa', [
                        'longitud' => strlen($textoIA)
                    ]);

                    return $this->procesarRespuestaIA($textoIA, $datosEstudiante);
                }
                // Si hay error de filtro de contenido
                elseif (isset($responseData['candidates'][0]['finishReason']) && 
                        $responseData['candidates'][0]['finishReason'] === 'SAFETY') {
                    
                    Log::warning('⚠️ Contenido bloqueado por filtros de seguridad', [
                        'response' => $responseData
                    ]);
                    
                    return $this->respuestaError('El análisis fue bloqueado por filtros de seguridad. Intenta con otro estudiante.');
                }
                else {
                    Log::error('❌ Estructura de respuesta inesperada del sistema de IA', [
                        'response_completa' => json_encode($responseData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
                        'candidates' => $responseData['candidates'] ?? 'No hay candidates',
                        'primera_candidate' => $responseData['candidates'][0] ?? 'No hay primera candidate'
                    ]);
                    
                    return $this->respuestaError('Error en el procesamiento del análisis. Revisa los logs para más detalles.');
                }
            } else {
                $errorBody = $response->body();
                $statusCode = $response->status();
                
                Log::error('❌ Error en respuesta del sistema de IA', [
                    'status' => $statusCode,
                    'error' => $errorBody
                ]);

                // Parsear el error para dar un mensaje más específico
                $errorMsg = "Error del sistema de IA (código {$statusCode})";
                
                try {
                    $errorJson = json_decode($errorBody, true);
                    if (isset($errorJson['error']['message'])) {
                        $errorMsg .= ": " . $errorJson['error']['message'];
                    }
                } catch (\Exception $e) {
                    $errorMsg .= ": " . $errorBody;
                }

                return $this->respuestaError($errorMsg);
            }

        } catch (\Exception $e) {
            Log::error('❌ Excepción durante el análisis predictivo', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return $this->respuestaError('Error al conectar con el sistema de IA: ' . $e->getMessage());
        }
    }

    protected function construirPrompt(array $datos): string
    {
        $estudiante = $datos['estudiante'];
        $notas = $datos['notas'];
        $asistencias = $datos['asistencias'];
        $recursos = $datos['recursos'] ?? [];

        // Analizar cursos con bajo rendimiento
        $cursosBajos = [];
        foreach ($notas as $nota) {
            if ($nota['promedio_final'] < 14) {
                $cursosBajos[] = $nota['curso'];
            }
        }

        $notasTexto = "### 📚 NOTAS POR CURSO:\n";
        foreach ($notas as $nota) {
            $estado = $nota['promedio_final'] >= 14 ? '✅ Aprobado' : '⚠️ Necesita refuerzo';
            $notasTexto .= "- **{$nota['curso']}** {$estado}:\n";
            $notasTexto .= "  * Bimestre 1: {$nota['bimestre1']}\n";
            $notasTexto .= "  * Bimestre 2: {$nota['bimestre2']}\n";
            $notasTexto .= "  * Bimestre 3: {$nota['bimestre3']}\n";
            $notasTexto .= "  * Bimestre 4: {$nota['bimestre4']}\n";
            $notasTexto .= "  * **Promedio Final: {$nota['promedio_final']}**\n\n";
        }

        $recursosTexto = "";
        if (!empty($recursos)) {
            $recursosTexto = "### 📖 RECURSOS EDUCATIVOS DISPONIBLES:\n\n";
            
            // Agrupar recursos por curso
            $recursosPorCurso = [];
            foreach ($recursos as $recurso) {
                $curso = $recurso['curso'];
                if (!isset($recursosPorCurso[$curso])) {
                    $recursosPorCurso[$curso] = [];
                }
                $recursosPorCurso[$curso][] = $recurso;
            }
            
            // Mostrar recursos disponibles por curso
            foreach ($recursosPorCurso as $curso => $recursosDelCurso) {
                $esCursoBajo = in_array($curso, $cursosBajos);
                $marcador = $esCursoBajo ? '🚨 **PRIORITARIO**' : '';
                
                $recursosTexto .= "**{$curso}** {$marcador}:\n";
                foreach ($recursosDelCurso as $recurso) {
                    $icono = match($recurso['tipo']) {
                        'video' => '🎥',
                        'pdf' => '📄',
                        'link' => '🔗',
                        default => '📚'
                    };
                    $recursosTexto .= "  {$icono} {$recurso['titulo']} ({$recurso['tipo']})";
                    if (!empty($recurso['descripcion'])) {
                        $recursosTexto .= " - {$recurso['descripcion']}";
                    }
                    $recursosTexto .= "\n";
                }
                $recursosTexto .= "\n";
            }
        }

        $cursosBajosTexto = !empty($cursosBajos) 
            ? "**CURSOS CON BAJO RENDIMIENTO (< 14):** " . implode(', ', $cursosBajos)
            : "El estudiante no tiene cursos con bajo rendimiento crítico.";

        return <<<PROMPT
Eres un sistema experto de análisis educativo con Inteligencia Artificial avanzada. Tu función es analizar el rendimiento académico de estudiantes y generar predicciones precisas basadas en datos históricos y patrones de aprendizaje.

## 👨‍🎓 INFORMACIÓN DEL ESTUDIANTE
- Nombre: {$estudiante['nombre']}
- Sección: {$estudiante['seccion']}
- Promedio año anterior: {$estudiante['promedio_anterior']}
- Nivel de motivación: {$estudiante['motivacion']}

{$notasTexto}

{$cursosBajosTexto}

### 📅 REGISTRO DE ASISTENCIA
- Total de clases: {$asistencias['total']}
- Asistencias: {$asistencias['presentes']}
- Ausencias: {$asistencias['ausentes']}
- Porcentaje de asistencia: {$asistencias['porcentaje']}%

{$recursosTexto}

## 📊 ANÁLISIS PREDICTIVO REQUERIDO

Como sistema de IA educativa, proporciona un análisis completo con el siguiente formato:

### 1. PROBABILIDAD DE APROBAR EL AÑO ESCOLAR
Calcula una probabilidad precisa (0-100) considerando:
- Promedio ponderado de todas las asignaturas
- Tendencia de rendimiento (mejorando/estable/declinando)
- Impacto del porcentaje de asistencia
- Número y criticidad de cursos en riesgo
- Comparación con promedio del año anterior

### 2. NIVEL DE RIESGO ACADÉMICO
Clasifica el riesgo como:
- **Bajo** (probabilidad > 70%): Estudiante en camino a aprobar sin problemas
- **Medio** (probabilidad 50-70%): Requiere atención y seguimiento
- **Alto** (probabilidad < 50%): Requiere intervención urgente

### 3. ANÁLISIS DETALLADO DEL RENDIMIENTO
Proporciona un análisis profundo de 3-4 párrafos que incluya:
- Evaluación del rendimiento general y tendencias identificadas
- Análisis comparativo entre diferentes asignaturas
- Impacto documentado de la asistencia en el desempeño
- Proyección fundamentada del rendimiento futuro
- Factores de riesgo y oportunidades detectadas

### 4. FORTALEZAS IDENTIFICADAS
Lista mínimo 3-5 fortalezas específicas y medibles del estudiante basadas en los datos

### 5. DEBILIDADES Y ÁREAS DE MEJORA
Lista mínimo 3-5 áreas específicas que requieren atención y desarrollo

### 6. RECOMENDACIONES GENERALES
Proporciona mínimo 5-7 recomendaciones prácticas, específicas y accionables para mejorar el rendimiento

### 7. RECURSOS EDUCATIVOS RECOMENDADOS
**CRÍTICO:** Para cada curso con bajo rendimiento (< 14), asigna recursos específicos de la lista disponible.

Formato OBLIGATORIO para cada recomendación:
```
- Curso: [Nombre exacto del curso]
  Recurso: [Título EXACTO del recurso de la lista disponible]
  Razón: [Explicación detallada de cómo este recurso específico ayudará al estudiante]
```

**RESTRICCIONES:**
- SOLO recomienda recursos que aparecen en "RECURSOS EDUCATIVOS DISPONIBLES"
- Si un curso no tiene recursos, indica: "Pendiente de asignación de material didáctico"
- Prioriza cursos marcados como 🚨 PRIORITARIO
- Relaciona el recurso específicamente con la debilidad detectada

### 8. CURSOS CRÍTICOS
Identifica y lista los cursos que requieren intervención urgente (promedio < 11)

### 9. PLAN DE MEJORA PERSONALIZADO
Diseña un plan detallado de 6-8 pasos con:
- Acciones específicas semanales priorizadas
- Objetivos SMART (específicos, medibles, alcanzables, relevantes, temporales)
- Cronograma realista y escalonado
- Hábitos de estudio recomendados basados en el perfil
- Estrategias de seguimiento y evaluación
- Puntos de control y métricas de éxito

## INSTRUCCIONES ADICIONALES
- Utiliza un tono profesional pero accesible
- Fundamenta cada conclusión en los datos proporcionados
- Sé específico, evita generalidades
- Proporciona recomendaciones prácticas y accionables
- Estructura tu respuesta de manera clara y ordenada
PROMPT;
    }

    protected function procesarRespuestaIA(string $textoIA, array $datosEstudiante): array
    {
        Log::info('🔄 Procesando análisis generado por IA...');

        $notas = collect($datosEstudiante['notas']);
        $promedioGeneral = $notas->avg('promedio_final');
        $porcentajeAsistencia = $datosEstudiante['asistencias']['porcentaje'] ?? 0;

        // Extraer probabilidad
        $probabilidad = $this->extraerProbabilidad($textoIA, $promedioGeneral, $porcentajeAsistencia);
        
        // Determinar riesgo
        $nivelRiesgo = $this->determinarNivelRiesgo($textoIA, $probabilidad);
        
        // Extraer secciones
        $fortalezas = $this->extraerSeccion($textoIA, ['FORTALEZAS', 'Fortalezas', 'PUNTOS FUERTES', 'Puntos Fuertes']);
        $debilidades = $this->extraerSeccion($textoIA, ['DEBILIDADES', 'Debilidades', 'ÁREAS DE MEJORA', 'Áreas de mejora', 'ÁREAS DE OPORTUNIDAD']);
        $recomendaciones = $this->extraerSeccion($textoIA, ['RECOMENDACIONES', 'Recomendaciones', 'SUGERENCIAS', 'Sugerencias']);
        $cursosCriticos = $this->extraerCursosCriticos($textoIA, $notas);
        $recursosRecomendados = $this->extraerRecursosRecomendados($textoIA);
        
        $resultado = [
            'probabilidad_aprobar' => $probabilidad,
            'prediccion_binaria' => $probabilidad >= 50,
            'nivel_riesgo' => $nivelRiesgo,
            'analisis' => $textoIA,
            'fortalezas' => $fortalezas,
            'debilidades' => $debilidades,
            'recomendaciones_generales' => $recomendaciones,
            'recursos_recomendados' => $recursosRecomendados,
            'cursos_criticos' => $cursosCriticos,
            'plan_mejora' => $this->extraerPlanMejora($textoIA)
        ];

        Log::info('✅ Análisis de IA procesado exitosamente', [
            'probabilidad' => $probabilidad,
            'riesgo' => $nivelRiesgo,
            'fortalezas_count' => count($fortalezas),
            'debilidades_count' => count($debilidades),
            'recursos_recomendados_count' => count($recursosRecomendados)
        ]);

        return $resultado;
    }

    protected function extraerProbabilidad(string $texto, float $promedioGeneral, float $asistencia): float
    {
        // Intentar extraer del texto generado por IA
        if (preg_match('/probabilidad[^\d]*(\d+(?:\.\d+)?)\s*%?/i', $texto, $matches)) {
            return (float) $matches[1];
        }

        // Calcular basado en modelo predictivo interno
        $probabilidad = ($promedioGeneral / 20 * 70) + ($asistencia / 100 * 30);
        
        return min(100, max(0, round($probabilidad, 2)));
    }

    protected function determinarNivelRiesgo(string $texto, float $probabilidad): string
    {
        if (preg_match('/riesgo\s*(alto|medio|bajo)/i', $texto, $matches)) {
            return ucfirst(strtolower($matches[1]));
        }

        // Clasificación automática basada en probabilidad
        if ($probabilidad >= 70) return 'Bajo';
        if ($probabilidad >= 50) return 'Medio';
        return 'Alto';
    }

    protected function extraerSeccion(string $texto, array $palabrasClave): array
    {
        foreach ($palabrasClave as $palabra) {
            if (preg_match("/{$palabra}[:\s]+(.*?)(?=\n\n|###|\z)/is", $texto, $matches)) {
                $contenido = $matches[1];
                $items = preg_split('/\n[-•*]\s*/', $contenido);
                return array_values(array_filter(array_map('trim', $items)));
            }
        }

        return [];
    }

    protected function extraerCursosCriticos(string $texto, $notas): array
    {
        $criticos = [];

        // Buscar en el análisis de IA
        if (preg_match('/cursos?\s*cr[íi]ticos?[:\s]+(.*?)(?=\n\n|###|\z)/is', $texto, $matches)) {
            $contenido = $matches[1];
            preg_match_all('/(?:^|\n)[-•*]\s*([^\n]+)/i', $contenido, $items);
            $criticos = array_map('trim', $items[1]);
        }

        // Agregar cursos con promedio crítico detectados automáticamente
        foreach ($notas as $nota) {
            if ($nota['promedio_final'] < 11 && !in_array($nota['curso'], $criticos)) {
                $criticos[] = $nota['curso'];
            }
        }

        return array_values(array_unique($criticos));
    }

    protected function extraerRecursosRecomendados(string $texto): array
    {
        $recursos = [];

        Log::info('🔍 Extrayendo recursos recomendados del análisis de IA...');

        // Buscar sección de recursos en el análisis
        if (preg_match('/RECURSOS?\s*(?:EDUCATIVOS?\s*)?RECOMENDADOS?[:\s]+(.*?)(?=\n\n###|\n###|CURSOS?\s*CR[ÍI]TICOS?|\z)/is', $texto, $matches)) {
            $contenido = $matches[1];
            
            Log::info('📋 Sección de recursos encontrada', [
                'longitud' => strlen($contenido),
                'preview' => substr($contenido, 0, 200)
            ]);

            // Patrón mejorado para capturar recursos con formato específico
            // Formato: - Curso: XXX / Recurso: YYY / Razón: ZZZ
            preg_match_all('/[-•*]\s*Curso:\s*([^\n]+?)\s*Recurso:\s*([^\n]+?)\s*Raz[oó]n:\s*([^\n]+)/is', $contenido, $matches2, PREG_SET_ORDER);
            
            foreach ($matches2 as $match) {
                if (count($match) >= 4) {
                    $recursos[] = [
                        'curso' => trim($match[1]),
                        'recurso' => trim($match[2]),
                        'razon' => trim($match[3])
                    ];
                }
            }

            // Si no encontró con el formato exacto, intentar formato alternativo
            if (empty($recursos)) {
                Log::info('⚠️ Probando formato alternativo de extracción...');
                
                preg_match_all('/[-•*]\s*([^:\n]+):\s*([^(\n]+?)(?:\s*-\s*|\s*\()?([^)\n]+)?/i', $contenido, $matches3, PREG_SET_ORDER);
                
                foreach ($matches3 as $match) {
                    if (isset($match[1]) && isset($match[2])) {
                        $recursos[] = [
                            'curso' => trim($match[1]),
                            'recurso' => trim($match[2]),
                            'razon' => isset($match[3]) ? trim($match[3]) : 'Recurso recomendado por el sistema de IA'
                        ];
                    }
                }
            }
        }

        Log::info('✅ Recursos extraídos del análisis', [
            'cantidad' => count($recursos),
            'recursos' => $recursos
        ]);

        return $recursos;
    }

    protected function extraerPlanMejora(string $texto): string
    {
        if (preg_match('/plan\s+de\s+mejora[:\s]+(.*?)(?=\n\n###|\z)/is', $texto, $matches)) {
            return trim($matches[1]);
        }

        return 'Plan de mejora incluido en el análisis general del sistema de IA.';
    }

    protected function respuestaError(string $mensaje): array
    {
        return [
            'probabilidad_aprobar' => 50.00,
            'prediccion_binaria' => false,
            'nivel_riesgo' => 'Medio',
            'analisis' => "⚠️ ERROR EN EL SISTEMA DE IA: {$mensaje}\n\nNo se pudo completar el análisis automático. Se requiere evaluación manual del tutor académico para generar el reporte de predicción.",
            'fortalezas' => ['Pendiente de evaluación manual por el tutor'],
            'debilidades' => ['Requiere análisis detallado personalizado'],
            'recomendaciones_generales' => ['Solicitar evaluación personalizada del equipo docente'],
            'recursos_recomendados' => [],
            'cursos_criticos' => [],
            'plan_mejora' => 'Se requiere evaluación manual del tutor para crear un plan de mejora personalizado.'
        ];
    }
}