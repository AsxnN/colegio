<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RecursoEducativo;
use App\Models\Curso;

class RecursosEducativosSeeder extends Seeder
{
    public function run(): void
    {
        $cursos = Curso::all();

        if ($cursos->isEmpty()) {
            $this->command->error('No hay cursos disponibles. Ejecuta primero CursoSeeder.');
            return;
        }

        $this->command->info('🚀 Iniciando creación de recursos educativos...');
        $this->command->info('📚 Creando 4 recursos por curso...');
        $this->command->info('');

        $recursosData = [
            'Matemática I' => [
                [
                    'titulo' => 'Álgebra Básica - Libro Interactivo',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/matematica-algebra-basica.pdf',
                    'descripcion' => 'Libro completo sobre álgebra básica con ejercicios resueltos y propuestos. Incluye: ecuaciones lineales, sistemas de ecuaciones, factorización y productos notables.',
                ],
                [
                    'titulo' => 'Geometría Plana - Guía de Estudio',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/matematica-geometria-plana.pdf',
                    'descripcion' => 'Manual de geometría plana con teoremas, demostraciones y problemas aplicados. Contenido: triángulos, cuadriláteros, círculos y polígonos.',
                ],
                [
                    'titulo' => 'Video Tutorial: Ecuaciones de Segundo Grado',
                    'tipo' => 'video',
                    'url' => 'https://youtube.com/watch?v=matematica-ecuaciones',
                    'descripcion' => 'Serie de videos explicativos sobre resolución de ecuaciones cuadráticas, fórmula general, discriminante y aplicaciones prácticas.',
                ],
                [
                    'titulo' => 'Trigonometría - Razones Trigonométricas',
                    'tipo' => 'link',
                    'url' => 'https://www.educacion.pe/matematica/trigonometria',
                    'descripcion' => 'Recurso interactivo sobre razones trigonométricas, identidades fundamentales, ángulos notables y resolución de triángulos.',
                ],
            ],
            'Comunicación I' => [
                [
                    'titulo' => 'Gramática Española - Manual Completo',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/comunicacion-gramatica.pdf',
                    'descripcion' => 'Libro de gramática española con todas las reglas ortográficas, sintaxis y morfología. Ideal para reforzar la escritura correcta.',
                ],
                [
                    'titulo' => 'Literatura Peruana - Antología',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/comunicacion-literatura-peruana.pdf',
                    'descripcion' => 'Recopilación de obras y autores peruanos representativos: Ricardo Palma, César Vallejo, José María Arguedas, Mario Vargas Llosa.',
                ],
                [
                    'titulo' => 'Comprensión Lectora - Estrategias',
                    'tipo' => 'link',
                    'url' => 'https://www.educacion.pe/comunicacion/lectura',
                    'descripcion' => 'Plataforma interactiva con técnicas y estrategias para mejorar la comprensión lectora: ideas principales, inferencias, análisis crítico.',
                ],
                [
                    'titulo' => 'Taller de Redacción - Video Curso',
                    'tipo' => 'video',
                    'url' => 'https://youtube.com/watch?v=comunicacion-redaccion',
                    'descripcion' => 'Curso en video sobre redacción de textos académicos, ensayos, cartas formales y técnicas de argumentación.',
                ],
            ],
            'Inglés' => [
                [
                    'titulo' => 'English Grammar in Use - Intermediate',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/ingles-grammar-use.pdf',
                    'descripcion' => 'Libro de gramática inglesa nivel intermedio con ejercicios prácticos. Cubre tiempos verbales, condicionales y voz pasiva.',
                ],
                [
                    'titulo' => 'Essential English Vocabulary',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/ingles-vocabulary.pdf',
                    'descripcion' => 'Diccionario temático con las 3000 palabras más importantes del inglés, incluye ejemplos de uso y pronunciación.',
                ],
                [
                    'titulo' => 'English Conversation Practice',
                    'tipo' => 'video',
                    'url' => 'https://youtube.com/watch?v=ingles-conversation',
                    'descripcion' => 'Serie de videos para practicar conversación en inglés: diálogos cotidianos, situaciones reales, pronunciación.',
                ],
                [
                    'titulo' => 'Interactive English Exercises',
                    'tipo' => 'link',
                    'url' => 'https://www.englishcentral.com/exercises',
                    'descripcion' => 'Plataforma interactiva con ejercicios de listening, reading, writing y speaking. Incluye evaluaciones automáticas.',
                ],
            ],
            'Ciencia y Tecnología' => [
                [
                    'titulo' => 'Biología General - Fundamentos',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/ciencia-biologia.pdf',
                    'descripcion' => 'Libro de biología que cubre célula, genética, evolución, ecosistemas y biodiversidad. Con ilustraciones y esquemas.',
                ],
                [
                    'titulo' => 'Química Básica - Teoría y Práctica',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/ciencia-quimica.pdf',
                    'descripcion' => 'Manual de química con tabla periódica, enlaces químicos, reacciones y estequiometría. Incluye experimentos.',
                ],
                [
                    'titulo' => 'Experimentos Científicos - Videos',
                    'tipo' => 'video',
                    'url' => 'https://youtube.com/watch?v=ciencia-experimentos',
                    'descripcion' => 'Colección de experimentos científicos explicados paso a paso: física, química y biología aplicada.',
                ],
                [
                    'titulo' => 'Método Científico - Guía Interactiva',
                    'tipo' => 'link',
                    'url' => 'https://www.educacion.pe/ciencia/metodo-cientifico',
                    'descripcion' => 'Recurso interactivo sobre el método científico: observación, hipótesis, experimentación y conclusiones.',
                ],
            ],
            'Física' => [
                [
                    'titulo' => 'Física I - Mecánica Clásica',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/fisica-mecanica.pdf',
                    'descripcion' => 'Libro de mecánica clásica: cinemática, dinámica, trabajo, energía y movimiento circular. Con problemas resueltos.',
                ],
                [
                    'titulo' => 'Electricidad y Magnetismo',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/fisica-electricidad.pdf',
                    'descripcion' => 'Manual sobre electricidad y magnetismo: carga eléctrica, campos, circuitos, ley de Ohm y electromagnetismo.',
                ],
                [
                    'titulo' => 'Física Experimental - Laboratorio',
                    'tipo' => 'video',
                    'url' => 'https://youtube.com/watch?v=fisica-laboratorio',
                    'descripcion' => 'Videos de experimentos de física con materiales simples: péndulo, caída libre, plano inclinado, circuitos.',
                ],
                [
                    'titulo' => 'Simulador de Física - PhET',
                    'tipo' => 'link',
                    'url' => 'https://phet.colorado.edu/es/simulations',
                    'descripcion' => 'Simulaciones interactivas de fenómenos físicos: movimiento, fuerzas, energía, ondas y electricidad.',
                ],
            ],
            'Historia' => [
                [
                    'titulo' => 'Historia del Perú - Época Colonial',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/historia-peru-colonial.pdf',
                    'descripcion' => 'Libro sobre la época colonial en el Perú: conquista española, virreinato, economía colonial y sociedad.',
                ],
                [
                    'titulo' => 'Historia Universal - Edad Contemporánea',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/historia-universal.pdf',
                    'descripcion' => 'Manual de historia universal moderna y contemporánea: revoluciones, guerras mundiales, guerra fría.',
                ],
                [
                    'titulo' => 'Documentales Históricos',
                    'tipo' => 'video',
                    'url' => 'https://youtube.com/playlist?list=historia-documentales',
                    'descripcion' => 'Lista de reproducción con documentales sobre civilizaciones antiguas, imperios y acontecimientos históricos.',
                ],
                [
                    'titulo' => 'Línea de Tiempo Interactiva',
                    'tipo' => 'link',
                    'url' => 'https://www.timetoast.com/historia-universal',
                    'descripcion' => 'Herramienta interactiva con líneas de tiempo de la historia universal y del Perú con fechas importantes.',
                ],
            ],
            'Geografía' => [
                [
                    'titulo' => 'Geografía del Perú - Atlas Completo',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/geografia-peru-atlas.pdf',
                    'descripcion' => 'Atlas geográfico del Perú con mapas físicos, políticos, regiones naturales, cuencas hidrográficas.',
                ],
                [
                    'titulo' => 'Geografía Física - Relieve y Clima',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/geografia-fisica.pdf',
                    'descripcion' => 'Libro sobre geografía física: formas del relieve, climas, ecosistemas y recursos naturales.',
                ],
                [
                    'titulo' => 'Geografía Económica - Video Curso',
                    'tipo' => 'video',
                    'url' => 'https://youtube.com/watch?v=geografia-economica',
                    'descripcion' => 'Videos sobre geografía económica: actividades productivas, comercio, industria y desarrollo regional.',
                ],
                [
                    'titulo' => 'Google Earth - Exploración Geográfica',
                    'tipo' => 'link',
                    'url' => 'https://earth.google.com/web/',
                    'descripcion' => 'Herramienta para explorar el mundo con mapas satelitales, relieve 3D y ubicaciones importantes.',
                ],
            ],
            'Educación Física' => [
                [
                    'titulo' => 'Fundamentos del Deporte - Manual',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/educacion-fisica-fundamentos.pdf',
                    'descripcion' => 'Manual sobre fundamentos deportivos: atletismo, fútbol, vóley, básquet. Reglas y técnicas básicas.',
                ],
                [
                    'titulo' => 'Anatomía y Fisiología Deportiva',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/educacion-fisica-anatomia.pdf',
                    'descripcion' => 'Libro sobre anatomía humana aplicada al deporte: músculos, huesos, sistemas y nutrición deportiva.',
                ],
                [
                    'titulo' => 'Rutinas de Ejercicios - Videos',
                    'tipo' => 'video',
                    'url' => 'https://youtube.com/watch?v=educacion-fisica-rutinas',
                    'descripcion' => 'Serie de videos con rutinas de calentamiento, ejercicios cardiovasculares, fuerza y flexibilidad.',
                ],
                [
                    'titulo' => 'Entrenamiento Deportivo Online',
                    'tipo' => 'link',
                    'url' => 'https://www.educacion.pe/educacion-fisica/entrenamiento',
                    'descripcion' => 'Plataforma con planes de entrenamiento personalizados, seguimiento de progreso y videos instructivos.',
                ],
            ],
            'Arte y Cultura' => [
                [
                    'titulo' => 'Historia del Arte Universal',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/arte-historia-universal.pdf',
                    'descripcion' => 'Libro ilustrado sobre historia del arte: arte antiguo, medieval, renacentista, moderno y contemporáneo.',
                ],
                [
                    'titulo' => 'Arte Peruano - Patrimonio Cultural',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/arte-peruano.pdf',
                    'descripcion' => 'Manual sobre arte peruano: culturas prehispánicas, arte colonial, arte popular y artistas contemporáneos.',
                ],
                [
                    'titulo' => 'Técnicas de Pintura y Dibujo',
                    'tipo' => 'video',
                    'url' => 'https://youtube.com/watch?v=arte-tecnicas-pintura',
                    'descripcion' => 'Tutoriales de pintura y dibujo: técnicas básicas, perspectiva, color, composición y estilos artísticos.',
                ],
                [
                    'titulo' => 'Museo Virtual de Arte',
                    'tipo' => 'link',
                    'url' => 'https://artsandculture.google.com/',
                    'descripcion' => 'Recorridos virtuales por museos del mundo, colecciones de arte y exposiciones interactivas.',
                ],
            ],
            'Computación' => [
                [
                    'titulo' => 'Fundamentos de Programación',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/computacion-programacion.pdf',
                    'descripcion' => 'Libro sobre fundamentos de programación: algoritmos, estructuras de datos, lógica de programación.',
                ],
                [
                    'titulo' => 'Microsoft Office - Guía Completa',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/computacion-office.pdf',
                    'descripcion' => 'Manual completo de Microsoft Office: Word, Excel, PowerPoint. Desde nivel básico hasta avanzado.',
                ],
                [
                    'titulo' => 'Programación en Python - Curso',
                    'tipo' => 'video',
                    'url' => 'https://youtube.com/watch?v=computacion-python',
                    'descripcion' => 'Curso completo de Python: variables, estructuras de control, funciones, POO y proyectos prácticos.',
                ],
                [
                    'titulo' => 'Codecademy - Aprender a Programar',
                    'tipo' => 'link',
                    'url' => 'https://www.codecademy.com/learn',
                    'descripcion' => 'Plataforma interactiva para aprender programación: Python, JavaScript, HTML, CSS y más lenguajes.',
                ],
            ],
            'Educación Cívica' => [
                [
                    'titulo' => 'Constitución Política del Perú',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/civica-constitucion.pdf',
                    'descripcion' => 'Texto completo de la Constitución Política del Perú con comentarios y análisis de artículos importantes.',
                ],
                [
                    'titulo' => 'Derechos Humanos - Manual',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/civica-derechos-humanos.pdf',
                    'descripcion' => 'Libro sobre derechos humanos: declaración universal, derechos fundamentales, garantías constitucionales.',
                ],
                [
                    'titulo' => 'Educación Ciudadana - Videos',
                    'tipo' => 'video',
                    'url' => 'https://youtube.com/watch?v=civica-ciudadania',
                    'descripcion' => 'Serie de videos sobre participación ciudadana, democracia, deberes y responsabilidades sociales.',
                ],
                [
                    'titulo' => 'Portal Ciudadano Interactivo',
                    'tipo' => 'link',
                    'url' => 'https://www.educacion.pe/civica/ciudadania',
                    'descripcion' => 'Plataforma con recursos sobre democracia, instituciones del Estado, elecciones y participación política.',
                ],
            ],
            'Tutoría' => [
                [
                    'titulo' => 'Orientación Vocacional - Guía',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/tutoria-vocacional.pdf',
                    'descripcion' => 'Guía para la elección de carrera profesional: test vocacionales, análisis de aptitudes y oferta educativa.',
                ],
                [
                    'titulo' => 'Inteligencia Emocional - Manual',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/tutoria-inteligencia-emocional.pdf',
                    'descripcion' => 'Libro sobre inteligencia emocional: autoconocimiento, empatía, manejo de emociones y habilidades sociales.',
                ],
                [
                    'titulo' => 'Técnicas de Estudio Efectivas',
                    'tipo' => 'video',
                    'url' => 'https://youtube.com/watch?v=tutoria-tecnicas-estudio',
                    'descripcion' => 'Videos sobre métodos de estudio: organización del tiempo, técnicas de memorización, toma de apuntes.',
                ],
                [
                    'titulo' => 'Prevención del Bullying',
                    'tipo' => 'link',
                    'url' => 'https://www.educacion.pe/tutoria/bullying',
                    'descripcion' => 'Recursos sobre prevención del acoso escolar: identificación, protocolos de intervención y apoyo.',
                ],
            ],
            'Religión' => [
                [
                    'titulo' => 'La Biblia - Antiguo y Nuevo Testamento',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/religion-biblia.pdf',
                    'descripcion' => 'Biblia completa con notas explicativas, concordancias y guías de estudio para jóvenes.',
                ],
                [
                    'titulo' => 'Catecismo de la Iglesia Católica',
                    'tipo' => 'pdf',
                    'url' => 'https://drive.google.com/file/d/religion-catecismo.pdf',
                    'descripcion' => 'Catecismo oficial con explicaciones sobre los sacramentos, moral cristiana y vida de oración.',
                ],
                [
                    'titulo' => 'Valores Cristianos - Videos',
                    'tipo' => 'video',
                    'url' => 'https://youtube.com/watch?v=religion-valores',
                    'descripcion' => 'Serie de videos sobre valores cristianos: amor, respeto, solidaridad, honestidad y perdón.',
                ],
                [
                    'titulo' => 'Recursos Pastorales Online',
                    'tipo' => 'link',
                    'url' => 'https://www.vatican.va/content/vatican/es.html',
                    'descripcion' => 'Portal del Vaticano con documentos papales, enseñanzas de la Iglesia y recursos de formación espiritual.',
                ],
            ],
        ];

        $totalRecursos = 0;

        foreach ($cursos as $curso) {
            if (isset($recursosData[$curso->nombre])) {
                foreach ($recursosData[$curso->nombre] as $recursoData) {
                    RecursoEducativo::create([
                        'curso_id' => $curso->id,
                        'titulo' => $recursoData['titulo'],
                        'tipo' => $recursoData['tipo'],
                        'url' => $recursoData['url'],
                        'descripcion' => $recursoData['descripcion'],
                    ]);
                    $totalRecursos++;
                }
                $this->command->info("✅ {$curso->nombre}: 4 recursos creados");
            }
        }

        $this->command->info('');
        $this->command->info('═══════════════════════════════════════════════');
        $this->command->info('✅ PROCESO COMPLETADO');
        $this->command->info('═══════════════════════════════════════════════');
        $this->command->info("📚 Total recursos creados: {$totalRecursos}");
        $this->command->info('📊 Recursos por curso: 4');
        $this->command->info('');
        $this->command->info('📝 DISTRIBUCIÓN POR TIPO:');
        $this->command->info('   - PDFs: ' . RecursoEducativo::where('tipo', 'pdf')->count());
        $this->command->info('   - Videos: ' . RecursoEducativo::where('tipo', 'video')->count());
        $this->command->info('   - Links: ' . RecursoEducativo::where('tipo', 'link')->count());
        $this->command->info('   - Otros: ' . RecursoEducativo::where('tipo', 'otro')->count());
        $this->command->info('═══════════════════════════════════════════════');
    }
}