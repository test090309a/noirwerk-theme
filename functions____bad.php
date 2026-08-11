<?php
/**
 * Noirwerk Theme Functions
 */

// ============================================================
// THEME SETUP
// ============================================================

function noirwerk_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
<<<<<<< HEAD
    add_theme_support('automatic-feed-links');
=======
>>>>>>> 2b7244c884dc4bb8a55445380d5fba8d39eb66f4
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 100,
        'flex-height' => true,
        'flex-width' => true,
    ));
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    register_nav_menus(array(
        'primary' => __('Hauptnavigation', 'noirwerk'),
        'footer' => __('Footer Navigation', 'noirwerk'),
        'social' => __('Social Links', 'noirwerk'),
    ));
}
add_action('after_setup_theme', 'noirwerk_setup');

// ============================================================
// ASSETS
// ============================================================

function noirwerk_assets() {
    wp_enqueue_style('noirwerk-main', get_stylesheet_directory_uri() . '/assets/css/main.css', array(), '1.0');
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@300;400;500;600;700&display=swap', array(), null);
    
<<<<<<< HEAD
    wp_enqueue_script('noirwerk-gsap', get_template_directory_uri() . '/assets/js/gsap.min.js', array(), '3.12.5', true);
    wp_enqueue_script('noirwerk-scrolltrigger', get_template_directory_uri() . '/assets/js/ScrollTrigger.min.js', array('noirwerk-gsap'), '3.12.5', true);
    wp_enqueue_script('noirwerk-lenis', get_template_directory_uri() . '/assets/js/lenis.min.js', array(), '1.1.14', true);
    wp_enqueue_script('noirwerk-split', get_template_directory_uri() . '/assets/js/split-type.min.js', array(), '0.3.4', true);
=======
    wp_enqueue_script('noirwerk-libs', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js', array(), '3.12.5', true);
    wp_enqueue_script('noirwerk-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js', array('noirwerk-libs'), '3.12.5', true);
    wp_enqueue_script('noirwerk-lenis', 'https://unpkg.com/lenis@1.1.14/dist/lenis.min.js', array(), '1.1.14', true);
    wp_enqueue_script('noirwerk-split', 'https://unpkg.com/split-type@0.3.4/umd/index.min.js', array(), '0.3.4', true);
>>>>>>> 2b7244c884dc4bb8a55445380d5fba8d39eb66f4
    wp_enqueue_script('noirwerk-main', get_stylesheet_directory_uri() . '/assets/js/main.js', array('noirwerk-libs', 'noirwerk-scrolltrigger'), '1.0', true);
    
    wp_localize_script('noirwerk-main', 'noirwerk_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('noirwerk_nonce'),
    ));
}
add_action('wp_enqueue_scripts', 'noirwerk_assets');

// ============================================================
// WIDGETS
// ============================================================

function noirwerk_widgets_init() {
    register_sidebar(array(
        'name' => __('Footer Bereich 1', 'noirwerk'),
        'id' => 'footer-1',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
    ));
    register_sidebar(array(
        'name' => __('Footer Bereich 2', 'noirwerk'),
        'id' => 'footer-2',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
    ));
    register_sidebar(array(
        'name' => __('Footer Bereich 3', 'noirwerk'),
        'id' => 'footer-3',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
    ));
    register_sidebar(array(
        'name' => __('Footer Bereich 4', 'noirwerk'),
        'id' => 'footer-4',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
    ));
}
add_action('widgets_init', 'noirwerk_widgets_init');

// ============================================================
// LAZY LOAD
// ============================================================

function noirwerk_lazy_load() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('img[data-src]');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    observer.unobserve(img);
                }
            });
        });
        images.forEach(img => observer.observe(img));
    });
    </script>
    <?php
}
add_action('wp_footer', 'noirwerk_lazy_load');

// ============================================================
// KONTAKTE DATENBANK
// ============================================================

function noirwerk_create_contacts_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'noirwerk_contacts';
    
    $charset_collate = $wpdb->get_charset_collate();
    
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id int(11) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        subject varchar(255) DEFAULT '',
        message text NOT NULL,
        status varchar(20) DEFAULT 'unread',
        created_at datetime DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
    ) $charset_collate;";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
register_activation_hook(__FILE__, 'noirwerk_create_contacts_table');

function noirwerk_save_contact($name, $email, $subject, $message) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'noirwerk_contacts';
    
    return $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
            'status' => 'unread',
            'created_at' => current_time('mysql')
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s')
    );
}

// ============================================================
// KONTAKTFORMULAR
// ============================================================

function noirwerk_handle_contact() {
    if (!isset($_POST['noirwerk_contact_nonce']) || !wp_verify_nonce($_POST['noirwerk_contact_nonce'], 'noirwerk_contact')) {
        wp_die('Sicherheitsfehler.');
    }
    
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);
    
    if (empty($name) || empty($email) || empty($message)) {
        wp_redirect(add_query_arg('error', 'empty', wp_get_referer()));
        exit;
    }
    
    if (!is_email($email)) {
        wp_redirect(add_query_arg('error', 'invalid_email', wp_get_referer()));
        exit;
    }
    
    // In Datenbank speichern
    noirwerk_save_contact($name, $email, $subject, $message);
    
    // E-Mail versenden
    $to = get_option('admin_email');
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $name . ' <' . $email . '>',
        'Reply-To: ' . $email,
    );
    
    $body = "
    <html>
    <head><style>
        body { font-family: 'IBM Plex Mono', monospace; background: #000; color: #fff; padding: 2rem; }
        .container { max-width: 600px; margin: 0 auto; border: 1px solid #D6001C; padding: 2rem; }
        h2 { color: #D6001C; text-transform: uppercase; letter-spacing: 0.2em; }
        .field { margin: 1rem 0; }
        .label { color: #666; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.2em; }
        .value { color: #fff; font-weight: 300; }
        .footer { margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #222; font-size: 0.6rem; color: #666; }
    </style></head>
    <body>
        <div class='container'>
            <h2>🔴 Neue Kontaktanfrage</h2>
            <div class='field'><div class='label'>Name</div><div class='value'>$name</div></div>
            <div class='field'><div class='label'>E-Mail</div><div class='value'>$email</div></div>
            <div class='field'><div class='label'>Betreff</div><div class='value'>$subject</div></div>
            <div class='field'><div class='label'>Nachricht</div><div class='value'>$message</div></div>
            <div class='footer'>Gesendet von noirwerk.studio</div>
        </div>
    </body>
    </html>
    ";
    
    wp_mail($to, 'Kontaktanfrage: ' . $subject, $body, $headers);
    
    wp_redirect(add_query_arg('success', '1', wp_get_referer()));
    exit;
}

add_action('admin_post_noirwerk_contact', 'noirwerk_handle_contact');
add_action('admin_post_nopriv_noirwerk_contact', 'noirwerk_handle_contact');

// ============================================================
// ADMIN DASHBOARD
// ============================================================

function noirwerk_admin_menu() {
    add_menu_page(
        'Kontaktanfragen',
        'Kontaktanfragen',
        'manage_options',
        'noirwerk-contacts',
        'noirwerk_contacts_page',
        'dashicons-email-alt',
        30
    );
    
    add_submenu_page(
        'noirwerk-contacts',
        'Alle Kontaktanfragen',
        'Alle Anfragen',
        'manage_options',
        'noirwerk-contacts',
        'noirwerk_contacts_page'
    );
}
add_action('admin_menu', 'noirwerk_admin_menu');

function noirwerk_contacts_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'noirwerk_contacts';
    
    // Löschen verarbeiten
    if (isset($_GET['delete']) && current_user_can('manage_options')) {
        $id = intval($_GET['delete']);
        $wpdb->delete($table_name, array('id' => $id), array('%d'));
        echo '<div class="notice notice-success"><p>Nachricht gelöscht.</p></div>';
    }
    
    // Alle Einträge abrufen
    $contacts = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");
    $unread_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'unread'");
    
    ?>
    <div class="wrap">
        <h1>Kontaktanfragen <span class="count">(<?php echo count($contacts); ?> total, <?php echo $unread_count; ?> ungelesen)</span></h1>
        
        <?php if (empty($contacts)) : ?>
            <div class="notice notice-info"><p>Keine Kontaktanfragen vorhanden.</p></div>
        <?php else : ?>
            <div style="margin: 20px 0;">
    <a href="<?php echo admin_url('admin.php?page=noirwerk-contacts&export_contacts=1'); ?>" class="button button-primary">📥 CSV Export</a>
</div>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Betreff</th>
                        <th>Status</th>
                        <th>Datum</th>
                        <th>Aktionen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($contacts as $contact) : ?>
                        <tr>
                            <td><?php echo $contact->id; ?></td>
                            <td><strong><?php echo esc_html($contact->name); ?></strong></td>
                            <td><a href="mailto:<?php echo esc_attr($contact->email); ?>"><?php echo esc_html($contact->email); ?></a></td>
                            <td><?php echo esc_html($contact->subject); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo $contact->status; ?>">
                                    <?php echo $contact->status; ?>
                                </span>
                            </td>
                            <td><?php echo date('d.m.Y H:i', strtotime($contact->created_at)); ?></td>
<td>
    <a href="<?php echo admin_url('admin.php?page=noirwerk-contacts&detail=' . $contact->id); ?>" class="button button-small">Anzeigen</a>
    <?php if ($contact->status == 'unread') : ?>
        <a href="<?php echo admin_url('admin.php?page=noirwerk-contacts&mark_read=' . $contact->id); ?>" class="button button-small button-success">Als gelesen</a>
    <?php endif; ?>
    <a href="<?php echo admin_url('admin.php?page=noirwerk-contacts&delete=' . $contact->id); ?>" class="button button-small button-danger" onclick="return confirm('Wirklich löschen?')">Löschen</a>
</td>
                        </tr>
                        <?php if (isset($_GET['detail']) && $_GET['detail'] == $contact->id) : ?>
                            <tr class="detail-row">
                                <td colspan="7">
                                    <div style="background:#f9f9f9;padding:20px;margin:10px 0;border-left:3px solid #D6001C;">
                                        <p><strong>Nachricht:</strong></p>
                                        <pre style="white-space:pre-wrap;background:#fff;padding:15px;border:1px solid #ddd;border-radius:4px;"><?php echo esc_html($contact->message); ?></pre>
                                        <p><small>Gesendet am: <?php echo date('d.m.Y H:i:s', strtotime($contact->created_at)); ?></small></p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    
    <style>
        .count { font-size: 14px; color: #666; font-weight: normal; }
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-unread { background: #D6001C; color: #fff; }
        .status-read { background: #00d084; color: #fff; }
        .button-danger { background: #D6001C !important; border-color: #D6001C !important; color: #fff !important; }
        .button-danger:hover { background: #a00015 !important; border-color: #a00015 !important; }
        .detail-row td { padding: 10px 20px !important; background: #f5f5f5; }
        pre { max-height: 300px; overflow-y: auto; }
    </style>
    <?php
}

// ============================================================
// E-MAILS IN DATEI SPEICHERN (FÜR TESTS)
// ============================================================

<<<<<<< HEAD
// add_filter('wp_mail', function($args) {
//     $log_dir = '/var/www/html/wp-content/uploads/';
//     if (!file_exists($log_dir)) {
//         mkdir($log_dir, 0755, true);
//     }
    
//     $log_file = $log_dir . 'mail.log';
//     $log = date('Y-m-d H:i:s') . "\n";
//     $log .= "TO: " . print_r($args['to'], true) . "\n";
//     $log .= "SUBJECT: " . $args['subject'] . "\n";
//     $log .= "MESSAGE:\n" . $args['message'] . "\n";
//     $log .= "HEADERS: " . print_r($args['headers'], true) . "\n";
//     $log .= str_repeat('=', 60) . "\n\n";
    
//     file_put_contents($log_file, $log, FILE_APPEND);
//     return $args;
// }, 10, 1);
=======
add_filter('wp_mail', function($args) {
    $log_dir = '/var/www/html/wp-content/uploads/';
    if (!file_exists($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    
    $log_file = $log_dir . 'mail.log';
    $log = date('Y-m-d H:i:s') . "\n";
    $log .= "TO: " . print_r($args['to'], true) . "\n";
    $log .= "SUBJECT: " . $args['subject'] . "\n";
    $log .= "MESSAGE:\n" . $args['message'] . "\n";
    $log .= "HEADERS: " . print_r($args['headers'], true) . "\n";
    $log .= str_repeat('=', 60) . "\n\n";
    
    file_put_contents($log_file, $log, FILE_APPEND);
    return $args;
}, 10, 1);
>>>>>>> 2b7244c884dc4bb8a55445380d5fba8d39eb66f4

add_filter('pre_wp_mail', function($null) {
    return true;
}, 10, 1);

// Als gelesen markieren
function noirwerk_mark_read() {
    if (isset($_GET['mark_read']) && current_user_can('manage_options')) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'noirwerk_contacts';
        $id = intval($_GET['mark_read']);
        $wpdb->update($table_name, array('status' => 'read'), array('id' => $id));
        wp_redirect(add_query_arg('updated', '1', admin_url('admin.php?page=noirwerk-contacts')));
        exit;
    }
}
add_action('admin_init', 'noirwerk_mark_read');

// Admin-Benachrichtigung für neue Anfragen
function noirwerk_admin_notice() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'noirwerk_contacts';
    $unread = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'unread'");
    
    if ($unread > 0) {
        echo '<div class="notice notice-warning"><p>📩 Sie haben ' . $unread . ' neue Kontaktanfrage(n). <a href="' . admin_url('admin.php?page=noirwerk-contacts') . '">Jetzt ansehen</a></p></div>';
    }
}
add_action('admin_notices', 'noirwerk_admin_notice');

// CSV-Export
<<<<<<< HEAD
// function noirwerk_export_contacts() {
//     if (isset($_GET['export_contacts']) && current_user_can('manage_options')) {
//         global $wpdb;
//         $table_name = $wpdb->prefix . 'noirwerk_contacts';
//         $contacts = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");
        
//         header('Content-Type: text/csv; charset=utf-8');
//         header('Content-Disposition: attachment; filename=kontaktanfragen.csv');
        
//         $output = fopen('php://output', 'w');
//         fputcsv($output, array('ID', 'Name', 'E-Mail', 'Betreff', 'Status', 'Datum', 'Nachricht'));
        
//         foreach ($contacts as $contact) {
//             fputcsv($output, array(
//                 $contact->id,
//                 $contact->name,
//                 $contact->email,
//                 $contact->subject,
//                 $contact->status,
//                 $contact->created_at,
//                 $contact->message
//             ));
//         }
//         fclose($output);
//         exit;
//     }
// }
// add_action('admin_init', 'noirwerk_export_contacts');

// Block-Styles & Patterns
add_theme_support('wp-block-styles');
add_theme_support('responsive-embeds');
add_theme_support('align-wide');
add_theme_support('custom-header', array(
    'default-image' => '',
    'flex-height' => true,
    'flex-width' => true,
));
add_theme_support('custom-background', array(
    'default-color' => '000000',
    'default-image' => '',
));
add_editor_style();
=======
function noirwerk_export_contacts() {
    if (isset($_GET['export_contacts']) && current_user_can('manage_options')) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'noirwerk_contacts';
        $contacts = $wpdb->get_results("SELECT * FROM $table_name ORDER BY created_at DESC");
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=kontaktanfragen.csv');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, array('ID', 'Name', 'E-Mail', 'Betreff', 'Status', 'Datum', 'Nachricht'));
        
        foreach ($contacts as $contact) {
            fputcsv($output, array(
                $contact->id,
                $contact->name,
                $contact->email,
                $contact->subject,
                $contact->status,
                $contact->created_at,
                $contact->message
            ));
        }
        fclose($output);
        exit;
    }
}
add_action('admin_init', 'noirwerk_export_contacts');
>>>>>>> 2b7244c884dc4bb8a55445380d5fba8d39eb66f4
