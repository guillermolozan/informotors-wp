# Contexto del Proyecto - InfoMotors

## Información General
- **Nombre:** InfoMotors
- **Plataforma:** WordPress (CMS)
- **URL Producción:** https://infomotors.pe/
- **URL Local:** http://localhost:10160
- **Propósito:** Gestión de contenido, usuarios y transacciones para informes vehiculares.
- **Alcance:** Este sistema NO genera los informes, solo gestiona la venta y entrega. La generación de informes se realiza en un sistema externo (scrapers/API).
- **Modelo de Negocio:** Servicio de informes por S/ 36.90 c/u + programa de afiliados.
- **Target:** Compradores/vendedores de vehículos usados en Perú.

## Arquitectura del Sistema
1. **Frontend y Gestión (WordPress, este proyecto):**
   - Gestión de contenido y páginas
   - Proceso de compra y pagos (WooCommerce)
   - Panel de usuario y descarga de informes
   - Programa de afiliados y soporte
2. **Sistema Externo de Generación de Informes:**
   - Scraping y consulta de fuentes oficiales
   - Procesamiento y generación de PDFs
   - API para integración con WordPress

## Fuentes de Datos (consultadas por el sistema externo)
- SUNARP, SAT Lima & Callao, SUTRAN, PNP, MTC/CITV, SOAT

## Funcionalidades Principales (WordPress)
- Gestión de contenido y páginas informativas
- Comercio electrónico: pagos, facturación, cupones
- Panel de usuario: historial, descarga de informes, soporte
- Programa de afiliados: registro, seguimiento, comisiones
- Integración con sistema externo vía API

## Funcionalidades del Tema Hijo (`functions.php`)
- Carga de estilos del tema padre
- Inclusión de lógica personalizada para informes (fase 1) y testimonios
- Seguridad básica: evita acceso directo

## Plugins Instalados Destacados
- WooCommerce, Contact Form 7, WP Mail SMTP, Yoast SEO, WP Rocket, Wordfence Security, Blocksy Companion, MercadoPago, Mailjet, Google Site Kit, Facebook for WooCommerce, entre otros

## Consideraciones
- El core de generación de informes y scraping NO está en este repositorio
- Este WordPress es crítico para la experiencia de usuario y la entrega del servicio
- Priorizar seguridad, rendimiento y disponibilidad
- Seguir buenas prácticas de desarrollo y estándares WordPress

1. **Generación de Informes:** Consulta múltiples APIs gubernamentales
2. **Procesamiento de Datos:** Integra información de 6 fuentes oficiales
3. **Generación PDF:** Informe completo en formato PDF
4. **Sistema de Pagos:** Procesamiento de pagos (S/ 36.90)
5. **Panel de Usuario:** `/mi-cuenta` - historial de informes comprados
6. **Sistema de Afiliados:** Programa de comisiones para socios
7. **Testimonios:** Sistema de reseñas de clientes

## Arquitectura Técnica (WordPress)
```
WordPress Frontend/Backend
├── wp-content/
│   ├── themes/blocksy-child/
│   │   ├── functions.php (hooks, APIs integrations)
│   │   ├── page-templates/ (landing, mi-cuenta, etc.)
│   │   └── assets/ (css, js, images)
│   ├── plugins/
│   │   ├── infomotors-core/ (plugin principal)
│   │   ├── woocommerce/ (pagos S/ 36.90)
│   │   └── custom-plugins/ (integraciones APIs)
│   └── uploads/ (PDFs generados)
├── wp-admin/ (panel administrativo)
└── wp-includes/ (core WordPress)

```

## Stack Tecnológico (WordPress)
- **CMS:** WordPress (PHP 7.4+ / 8.x)
- **Frontend:** WordPress Theme + Custom CSS/JS
- **Backend Logic:** Custom WordPress Plugin + functions.php
- **Base de Datos:** MySQL (WordPress default)
- **APIs Integration:** PHP cURL / WordPress HTTP API
- **Pagos:** WooCommerce + Pasarela peruana (Culqi, Niubiz, PayU, MercadoPago)
- **PDF Generation:** TCPDF, MPDF o DomPDF (PHP libraries)
- **Server:** Apache/Nginx + PHP-FPM
- **Local Environment:** XAMPP/WAMP/Local by Flywheel
- **Puerto Local:** 10160

## URLs y Endpoints Importantes
### Producción
- **Principal:** https://infomotors.pe/
- **Panel Usuario:** https://infomotors.pe/mi-cuenta
- **Admin:** https://infomotors.pe/wp-admin/

### Local (Desarrollo)
- **Principal:** http://localhost:10160/
- **Panel Usuario:** http://localhost:10160/mi-cuenta
- **WordPress Admin:** http://localhost:10160/wp-admin/

## Integraciones Críticas (APIs Externas)
1. **SUNARP** - Registros Públicos
2. **SAT Lima/Callao** - Tributario  
3. **SUTRAN** - Transporte
4. **PNP** - Policía Nacional
5. **MTC/CITV** - Transportes
6. **SOAT** - Seguros

## Consideraciones de Desarrollo
### Prioridades
1. **Disponibilidad:** APIs gubernamentales pueden tener downtime
2. **Velocidad:** Usuarios esperan informes "en minutos"
3. **Confiabilidad:** Datos deben ser 100% precisos
4. **Escalabilidad:** Manejar múltiples consultas simultáneas

### Challenges Técnicos
- **Rate Limiting:** APIs gubernamentales tienen límites
- **Timeouts:** Algunas APIs pueden ser lentas
- **Formatos Diversos:** Cada API retorna datos diferentes
- **Validación:** Verificar placas válidas antes de consultar
- **Caching:** Evitar consultas repetidas innecesarias

## Estructura WordPress del Proyecto
```
wp-content/
├── themes/
│   └── blocksy-child/
│       ├── functions.php (hooks, enqueue scripts, API calls)
│       ├── index.php (homepage)
│       ├── page-mi-cuenta.php (panel usuario)
│       ├── page-afiliados.php (programa afiliados)
│       ├── single-informe.php (página individual informe)
│       ├── assets/
│       │   ├── css/ (estilos custom)
│       │   ├── js/ (JavaScript para APIs)
│       │   └── images/
│       └── template-parts/
└── plugins/
    ├── woocommerce/ (manejo pagos)
    └── custom-user-management/

```

## Configuración WordPress Local
- **Puerto:** 10160
- **Base URL:** http://localhost:10160
- **Database:** local
- **Admin URL:** http://localhost:10160/wp-admin/
- **Usuario Admin:** [definir en wp-config.php]


## Métricas de Negocio
- **Precio por Informe:** S/ 36.90
- **Testimonios Recientes:** Junio 2024 (buena satisfacción cliente)
- **Fuentes:** 6 APIs oficiales integradas
- **Formato Output:** PDF completo

## Reglas de Desarrollo (WordPress)
1. **NUNCA** hacer consultas innecesarias a APIs gubernamentales
2. **SIEMPRE** validar formato de placa antes de consultar
3. **USAR** WordPress hooks y filters correctamente
4. **NO** hardcodear URLs - usar home_url() y site_url()
5. **ENQUEUE** scripts y styles usando wp_enqueue_script/style
6. **SANITIZAR** todos los inputs con WordPress functions
7. **USAR** WordPress HTTP API para llamadas externas
8. **CACHEAR** respuestas API usando WordPress Transients
9. **SEGUIR** WordPress Coding Standards
10. **BACKUP** base de datos antes de cambios mayores
11. **TESTING** en ambiente local (puerto 10160) antes de producción
12. **LOGGING** usando error_log() o WordPress debug.log
13. **SEGURIDAD** - validar nonces en formularios
14. **NO MODIFICAR** archivos core de WordPress

## Estados del Sistema
- **Desarrollo Local:** http://localhost:10160 (APIs de prueba o mocks)
- **Producción:** https://infomotors.pe/ (APIs oficiales con datos reales)

## Archivos Críticos WordPress
- **wp-config.php:** Configuración DB y constantes
- **functions.php:** Hooks y funciones del theme
- **.htaccess:** Reglas de reescritura
- **wp-content/plugins/infomotors-core/:** Plugin principal

## Notas para IA/Windsurf
- Este es un sistema **WordPress legacy crítico** que maneja datos oficiales
- **URL Local:** http://localhost:10160 para desarrollo y testing
- **NO modificar** archivos core de WordPress ni plugins de terceros
- **SIEMPRE** usar WordPress hooks, filters y APIs nativas
- **SEGUIR** WordPress Coding Standards y Security Guidelines
- **PRIORIZAR** disponibilidad y precisión sobre nuevas features
- **USAR** WordPress Transients API para cache
- **VALIDAR** con wp_verify_nonce() en formularios
- **ENQUEUE** assets correctamente con WordPress functions
- **DOCUMENTAR** cualquier cambio en theme o plugins custom