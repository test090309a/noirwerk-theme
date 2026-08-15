<?php
/**
 * Template Name: Kontakt
 * Template Post Type: page
 */

get_header(); ?>

<section class="contact-page" id="main">
    <div class="container">
        <div class="contact-page__header">
            <h1 class="contact-page__title"><?php the_title(); ?></h1>
            <?php if (has_excerpt()) : ?>
                <p class="contact-page__desc"><?php echo get_the_excerpt(); ?></p>
            <?php endif; ?>
        </div>
        
        <div class="contact-page__grid">
            <!-- Kontaktinformationen -->
            <div class="contact-page__info">
                <h3><?php _e('Kontaktieren Sie uns', 'noirwerk'); ?></h3>
                <p><?php _e('Erzählen Sie uns von Ihrem System. Wir antworten innerhalb von 24 Stunden.', 'noirwerk'); ?></p>
                
                <div class="contact-page__details">
                    <div>
                        <small><?php _e('Neue Projekte', 'noirwerk'); ?></small>
                        <a href="mailto:hello@noirwerk.studio">hello@noirwerk.studio</a>
                    </div>
                    <div>
                        <small><?php _e('Studio', 'noirwerk'); ?></small>
                        <p>Lerchenfelderstrasse, 10551 Wien</p>
                    </div>
                    <div>
                        <small><?php _e('Karriere', 'noirwerk'); ?></small>
                        <a href="mailto:join@noirwerk.studio">join@noirwerk.studio</a>
                    </div>
                </div>
            </div>
            
            <!-- Kontaktformular -->
            <div class="contact-page__form">
                <?php if (isset($_GET['success']) && $_GET['success'] == '1') : ?>
                    <div class="contact-success">
                        <h3>✅ Nachricht gesendet</h3>
                        <p>Ihre Nachricht wurde erfolgreich versendet. Wir melden uns in Kürze bei Ihnen.</p>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['error']) && $_GET['error'] == 'empty') : ?>
                    <div class="contact-error">
                        <h3>⚠️ Fehler</h3>
                        <p>Bitte füllen Sie alle Pflichtfelder aus.</p>
                    </div>
                <?php endif; ?>
                
                <form id="contactForm" class="contact-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <input type="hidden" name="action" value="noirwerk_contact">
                    <?php wp_nonce_field('noirwerk_contact', 'noirwerk_contact_nonce'); ?>
                    
                    <div class="form-group">
                        <label for="contact-name"><?php _e('Name *', 'noirwerk'); ?></label>
                        <input type="text" id="contact-name" name="name" placeholder="Ihr Name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-email"><?php _e('E-Mail *', 'noirwerk'); ?></label>
                        <input type="email" id="contact-email" name="email" placeholder="ihre@email.de" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-subject"><?php _e('Betreff', 'noirwerk'); ?></label>
                        <input type="text" id="contact-subject" name="subject" placeholder="Betreff Ihrer Nachricht">
                    </div>
                    
                    <div class="form-group">
                        <label for="contact-message"><?php _e('Nachricht *', 'noirwerk'); ?></label>
                        <textarea id="contact-message" name="message" rows="5" placeholder="Ihre Nachricht..." required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn--red">
                        <?php _e('Nachricht senden', 'noirwerk'); ?> <span class="arr">→</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
.contact-page {
    padding: 120px 0 60px;
    min-height: 100vh;
}
.contact-page__header {
    text-align: center;
    margin-bottom: 4rem;
}
.contact-page__title {
    font-size: clamp(2rem, 5vw, 3.5rem);
    color: var(--white);
    margin-bottom: 1rem;
}
.contact-page__desc {
    color: var(--w60);
    max-width: 50ch;
    margin: 0 auto;
    font-weight: 300;
}
.contact-page__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    max-width: 1100px;
    margin: 0 auto;
}
.contact-page__info h3 {
    font-size: 1.2rem;
    color: var(--white);
    margin-bottom: 1rem;
}
.contact-page__info p {
    color: var(--w60);
    font-weight: 300;
    margin-bottom: 2rem;
}
.contact-page__details {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}
.contact-page__details small {
    display: block;
    font-size: 0.6rem;
    letter-spacing: 0.34em;
    text-transform: uppercase;
    color: var(--w40);
    margin-bottom: 0.3rem;
}
.contact-page__details a,
.contact-page__details p {
    font-size: 0.9rem;
    color: var(--w80);
    text-decoration: none;
    transition: color 0.3s;
}
.contact-page__details a:hover {
    color: var(--red);
}
.contact-page__form .form-group {
    margin-bottom: 1.5rem;
}
.contact-page__form label {
    display: block;
    font-size: 0.6rem;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--w40);
    margin-bottom: 0.5rem;
}
.contact-page__form input,
.contact-page__form textarea {
    width: 100%;
    background: rgba(255,255,255,.02);
    border: 1px solid var(--w10);
    color: var(--white);
    padding: 0.8rem 1rem;
    font-family: var(--font);
    transition: border-color 0.3s;
}
.contact-page__form input:focus,
.contact-page__form textarea:focus {
    outline: none;
    border-color: var(--red);
}
.contact-page__form textarea {
    resize: vertical;
}
.contact-success,
.contact-error {
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid;
}
.contact-success {
    border-color: #00d084;
    background: rgba(0,208,132,.05);
}
.contact-success h3 {
    color: #00d084;
    margin-bottom: 0.5rem;
}
.contact-error {
    border-color: var(--red);
    background: rgba(214,0,28,.05);
}
.contact-error h3 {
    color: var(--red);
    margin-bottom: 0.5rem;
}
@media (max-width: 768px) {
    .contact-page__grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}
</style>

<?php get_footer(); ?>