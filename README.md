# Contexto del Proyecto - InfoMotors

## Información General del Proyecto
- **Nombre:** InfoMotors (Frontend y Gestión)
- **Plataforma:** WordPress (CMS)
- **URL Producción:** https://infomotors.pe/
- **URL Local:** http://localhost:10160
- **Propósito:** Plataforma de gestión de contenido y transacciones para informes vehiculares
- **Alcance:** Este repositorio contiene solo el frontend y la gestión de transacciones
- **Sistema de Informes:** La generación de informes se realiza mediante un sistema externo de scraping
- **Modelo de Negocio:** Servicio de informes por S/ 36.90 c/u + programa de afiliados
- **Target:** Compradores/vendedores de vehículos usados en Perú

## Descripción del Servicio
InfoMotors es el frontend y sistema de gestión para la comercialización de informes vehiculares. Los informes son generados por un sistema externo de scraping que consulta múltiples fuentes oficiales peruanas.

### Arquitectura del Sistema
1. **Frontend (Este repositorio)**:
   - Gestión de contenido (WordPress)
   - Proceso de compra y pagos
   - Panel de usuario
   - Programa de afiliados
   - Sistema de soporte

2. **Sistema de Generación de Informes (Externo)**:
   - Módulo de scraping de fuentes oficiales
   - Procesamiento de datos
   - Generación de PDFs
   - API para integración con el frontend

### Fuentes de Datos (Consultadas por el sistema externo)
- 🟠 **SUNARP:** Propiedad actual, historial de dueños
- 🔵 **SAT Lima & Callao:** Papeletas, deudas tributarias
- 🟢 **SUTRAN:** Uso vehicular, sanciones
- 🟣 **PNP:** Alertas de robo
- 🟡 **MTC/CITV:** Revisión técnica
- 🟤 **SOAT:** Estado del seguro

## Funcionalidades Principales
1. **Gestión de Contenido**:
   - Páginas informativas
   - Blog de noticias del sector
   - Preguntas frecuentes
   - Términos y condiciones

2. **Sistema de Comercio Electrónico**:
   - Procesamiento de pagos (S/ 36.90 por informe)
   - Gestión de pedidos
   - Facturación electrónica
   - Cupones de descuento

3. **Panel de Usuario**:
   - Historial de compras
   - Descarga de informes
   - Gestión de datos personales
   - Sistema de soporte

4. **Programa de Afiliados**:
   - Registro de afiliados
   - Seguimiento de referidos
   - Cálculo de comisiones
   - Retiros de fondos

5. **Sistema de Soporte**:
   - Tickets de soporte
   - Chat en vivo
   - Centro de ayuda

## Arquitectura Técnica

## Funcionalidades del Tema Hijo (`functions.php`)
- Carga de estilos del tema padre mediante `wp_enqueue_scripts`.
- Inclusión de lógica personalizada desde:
  - `inc/fase-1-informe.php` (lógica de informes, fase 1)
  - `inc/testimonios.php` (gestión de testimonios)
- Seguridad básica: evita acceso directo si no está definido `WP_DEBUG`.

## Plugins Instalados
Lista de plugins encontrados en `/wp-content/plugins`:

- all-in-one-wp-migration
- better-search-replace
- blocksy-companion
- cf7-google-sheets-connector
- click-to-chat-for-whatsapp
- contact-form-7
- easy-login-woocommerce
- facebook-for-woocommerce
- flamingo
- google-listings-and-ads
- google-site-kit
- greenshift-animation-and-page-builder-blocks
- insert-headers-and-footers
- kadence-woocommerce-email-designer
- mailjet-for-wordpress
- mensaje-yape
- official-facebook-pixel
- page-bloquer
- pymntpl-paypal-woocommerce
- slicewp
- tiktok-for-business
- woo-update-manager
- woocommerce
- woocommerce-mercadopago
- wordpress-seo
- wp-mail-smtp


### Este Repositorio (WordPress)
```
WordPress Frontend/Backend
├── wp-content/
│   ├── themes/blocksy-child/
│   │   ├── functions.php (hooks, configuraciones)
│   │   ├── page-templates/ (plantillas personalizadas)
│   │   └── assets/ (css, js, images)
│   ├── plugins/
│   │   ├── woocommerce/ (gestión de pagos)
│   │   ├── wp-mail-smtp/ (envío de correos)
│   │   └── otros-plugins/
│   └── uploads/ (archivos subidos)
├── wp-admin/
└── wp-includes/
```

### Sistema de Generación de Informes (Externo)
```
Sistema de Scraping
├── api/ (endpoints para WordPress)
├── scrapers/ (scripts para cada fuente de datos)
├── storage/ (PDFs generados)
└── logs/ (registros del sistema)
```

## Stack Tecnológico (WordPress)
- **CMS:** WordPress (PHP 7.4+ / 8.x)
- **Frontend:** WordPress Theme + Custom CSS/JS
- **Backend Logic:** Custom WordPress Plugin + functions.php
- **Base de Datos:** MySQL (WordPress default)
- **APIs Integration:** PHP cURL / WordPress HTTP API
- **Pagos:** WooCommerce + Pasarela peruana (Culqi, Niubiz, PayU)
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

## Integraciones

### Con el Sistema de Generación de Informes
1. **API de Generación de Informes**
   - Endpoint para solicitar nuevos informes
   - Webhooks para notificaciones de estado
   - Descarga de PDFs generados

### Con Servicios de Terceros
1. **Pasarelas de Pago**
   - Culqi
   - Niubiz
   - PayPal
   - MercadoPago

2. **Servicios de Email**
   - Mailjet

3. **Herramientas de Análisis**
   - Google Analytics
   - Facebook Pixel

## Consideraciones de Desarrollo

### Prioridades
1. **Experiencia de Usuario**: Interfaz intuitiva y rápida
2. **Seguridad**: Protección de datos de usuarios y transacciones
3. **Rendimiento**: Tiempos de carga óptimos
4. **Disponibilidad**: Mínimo tiempo de inactividad

### Flujo de Trabajo Típico
1. Usuario solicita un informe en el frontend
2. Sistema registra la transacción en WooCommerce
3. Se notifica al sistema de generación de informes
4. El sistema externo procesa la solicitud
5. Se notifica al usuario cuando el informe está listo
6. El usuario descarga el PDF desde su panel

### Consideraciones Técnicas
- **Sincronización**: Mantener consistencia entre sistemas
- **Logs**: Registrar todas las interacciones importantes
- **Backups**: Copias de seguridad regulares
- **Monitoreo**: Seguimiento del estado del sistema

## Estructura del Tema Hijo

```
themes/blocksy-child/
├── functions.php          # Configuraciones principales
├── style.css              # Estilos personalizados
├── assets/
│   ├── css/              # Hojas de estilo adicionales
│   ├── js/               # Scripts personalizados
│   └── images/           # Imágenes del tema
├── inc/
│   ├── fase-1-informe.php # Lógica de la primera fase
│   └── testimonios.php    # Manejo de testimonios
└── template-parts/       # Partes reutilizables
    ├── header-custom.php
    └── footer-custom.php
```

### Plugins Principales
- **WooCommerce**: Gestión de productos y pagos
- **WP Mail SMTP**: Envío de correos
- **Yoast SEO**: Optimización para motores de búsqueda
- **WP Rocket**: Caché y optimización
- **Wordfence Security**: Seguridad del sitio

## Configuración de Desarrollo Local

### Requisitos
- PHP 8.3 o superior
- MySQL 5.7 o MariaDB 10.3+
- WordPress 5.8+
- WooCommerce 5.5+




## Métricas y Monitoreo

### Métricas de Negocio
- **Precio por Informe:** S/ 36.90
- **Tasa de Conversión:** [Por definir]
- **Usuarios Activos:** [Por definir]
- **Tiempo Promedio de Generación:** [Por definir]

### Monitoreo
- **Disponibilidad del Sitio:** Uptime Robot
- **Rendimiento:** New Relic / Query Monitor
- **Errores:** Sentry / Rollbar
- **Analítica:** Google Analytics 4

## Guía de Desarrollo

### Estándares de Código
1. **WordPress Coding Standards** - Seguir los estándares de WordPress
2. **PHP 7.4+** - Usar características modernas de PHP
3. **PSR-4** - Para autoloading de clases
4. **Composer** - Para gestión de dependencias

### Buenas Prácticas
1. **Seguridad**
   - Validar y sanitizar todas las entradas de usuario
   - Usar nonces para formularios y AJAX
   - Implementar CSRF protection
   - Usar funciones de seguridad de WordPress

2. **Rendimiento**
   - Usar transients para cache
   - Implementar lazy loading para imágenes
   - Minificar y combinar archivos CSS/JS
   - Usar CDN para recursos estáticos

3. **Mantenibilidad**
   - Documentar el código
   - Usar constantes para valores configurables
   - Separar la lógica de negocio de la presentación
   - Usar namespaces para evitar colisiones

### Integración con el Sistema de Informes
1. **Comunicación**
   - Usar webhooks para notificaciones
   - Implementar reintentos para fallos de conexión
   - Validar respuestas del sistema externo

2. **Manejo de Errores**
   - Registrar todos los errores de integración
   - Notificar a los administradores en fallos críticos
   - Proporcionar mensajes claros al usuario final

## Entornos de Despliegue

### Desarrollo Local
- **URL:** http://localhost:10160
- **Base de Datos:** Local
- **Características:**
  - Debug activado
  - Mocks para el sistema de informes
  - Datos de prueba

### Staging
- **URL:** https://staging.infomotors.pe/
- **Base de Datos:** Servidor de staging
- **Características:**
  - Sistema de informes en modo prueba
  - Datos reales pero aislados
  - Monitoreo activo

### Producción
- **URL:** https://infomotors.pe/
- **Base de Datos:** Servidor de producción
- **Características:**
  - Sistema de informes en producción
  - Datos reales
  - Alto rendimiento
  - Monitoreo 24/7

## Archivos Críticos
- **wp-config.php**: Configuración principal
- **.htaccess**: Reglas de reescritura
- **wp-content/mu-plugins/**: Must-Use Plugins
- **wp-content/plugins/woocommerce/**: Configuración de e-commerce


## Notas para Desarrolladores

### Entorno de Desarrollo
- **URL Local:** http://localhost:10160
- **Base de Datos:** MySQL/MariaDB
- **Versión PHP:** 8.3+

### Convenciones de Código
1. **Estructura de Archivos**
   - Usar nombres en inglés
   - Seguir la estructura de WordPress
   - Documentar funciones complejas

2. **Base de Datos**
   - Usar el prefijo `wp_` por defecto
   - Crear migraciones .sql para cambios en la estructura
   - No modificar tablas de WordPress directamente

