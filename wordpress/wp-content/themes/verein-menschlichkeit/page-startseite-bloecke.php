<?php
/**
 * Template Name: Startseite mit Blöcken
 * 
 * Beispiel-Template, das die wichtigsten Vereins-Blöcke demonstriert
 */

get_header(); ?>

<div class="verein-homepage">
    <?php
    // Prüfen, ob die Seite Gutenberg-Blöcke verwendet
    if (has_blocks()) {
        // Blocks anzeigen
        the_content();
    } else {
        // Fallback: Beispiel-Layout mit den wichtigsten Blöcken
        ?>
        
        <!-- Hero-Section -->
        <section class="hero-section-demo">
            <div class="container">
                <h1>Willkommen bei Verein Menschlichkeit</h1>
                <p>Gemeinsam für eine bessere Welt - Ihre Unterstützung macht den Unterschied</p>
                <div class="hero-buttons">
                    <a href="#mitglied-werden" class="btn btn-primary">Mitglied werden</a>
                    <a href="#spenden" class="btn btn-secondary">Jetzt spenden</a>
                </div>
            </div>
        </section>

        <!-- Wichtige Zahlen -->
        <section class="wichtige-zahlen-demo">
            <div class="container">
                <div class="zahlen-grid">
                    <div class="zahl-item">
                        <span class="zahl">1.250</span>
                        <span class="beschreibung">Aktive Mitglieder</span>
                    </div>
                    <div class="zahl-item">
                        <span class="zahl">45</span>
                        <span class="beschreibung">Laufende Projekte</span>
                    </div>
                    <div class="zahl-item">
                        <span class="zahl">€285.000</span>
                        <span class="beschreibung">Spendensumme 2024</span>
                    </div>
                    <div class="zahl-item">
                        <span class="zahl">12</span>
                        <span class="beschreibung">Jahre Erfahrung</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Aktuelle Projekte -->
        <section class="projekte-demo">
            <div class="container">
                <h2>Unsere aktuellen Projekte</h2>
                <div class="projekt-grid">
                    <div class="projekt-karte">
                        <h3>Bildung für alle</h3>
                        <p>Unterstützung von Kindern in benachteiligten Gebieten</p>
                        <div class="projekt-fortschritt">
                            <div class="fortschritt-balken">
                                <div class="fortschritt-fill" style="width: 75%"></div>
                            </div>
                            <span>75% erreicht</span>
                        </div>
                    </div>
                    <div class="projekt-karte">
                        <h3>Sauberes Wasser</h3>
                        <p>Brunnenbau in ländlichen Gemeinden</p>
                        <div class="projekt-fortschritt">
                            <div class="fortschritt-balken">
                                <div class="fortschritt-fill" style="width: 60%"></div>
                            </div>
                            <span>60% erreicht</span>
                        </div>
                    </div>
                    <div class="projekt-karte">
                        <h3>Medizinische Hilfe</h3>
                        <p>Mobile Kliniken für abgelegene Regionen</p>
                        <div class="projekt-fortschritt">
                            <div class="fortschritt-balken">
                                <div class="fortschritt-fill" style="width: 40%"></div>
                            </div>
                            <span>40% erreicht</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mitmachen -->
        <section class="mitmachen-demo">
            <div class="container">
                <h2>So können Sie helfen</h2>
                <div class="mitmach-optionen">
                    <div class="mitmach-karte">
                        <h3>Mitglied werden</h3>
                        <p>Werden Sie Teil unserer Gemeinschaft</p>
                        <ul>
                            <li>Regelmäßige Updates</li>
                            <li>Mitbestimmung</li>
                            <li>Vergünstigungen</li>
                        </ul>
                        <a href="#" class="btn btn-primary">Jetzt Mitglied werden</a>
                    </div>
                    <div class="mitmach-karte">
                        <h3>Spenden</h3>
                        <p>Unterstützen Sie unsere Projekte</p>
                        <ul>
                            <li>Einmalig oder regelmäßig</li>
                            <li>Transparent verwendet</li>
                            <li>Steuerlich absetzbar</li>
                        </ul>
                        <a href="#" class="btn btn-secondary">Jetzt spenden</a>
                    </div>
                    <div class="mitmach-karte">
                        <h3>Ehrenamt</h3>
                        <p>Bringen Sie Ihre Fähigkeiten ein</p>
                        <ul>
                            <li>Flexible Zeiteinteilung</li>
                            <li>Sinnvolle Aufgaben</li>
                            <li>Neue Kontakte</li>
                        </ul>
                        <a href="#" class="btn btn-outline">Freiwillig helfen</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="testimonials-demo">
            <div class="container">
                <h2>Was unsere Mitglieder sagen</h2>
                <div class="testimonials-grid">
                    <div class="testimonial">
                        <p>"Die Arbeit des Vereins ist beeindruckend. Ich bin stolz, Teil davon zu sein."</p>
                        <cite>— Maria Schmidt, Mitglied seit 2020</cite>
                    </div>
                    <div class="testimonial">
                        <p>"Transparenz und Effizienz - hier weiß ich, dass meine Spende ankommt."</p>
                        <cite>— Thomas Müller, Spender</cite>
                    </div>
                    <div class="testimonial">
                        <p>"Das Ehrenamt hier gibt mir viel zurück. Tolle Gemeinschaft!"</p>
                        <cite>— Anna Weber, Ehrenamtliche</cite>
                    </div>
                </div>
            </div>
        </section>

        <!-- Newsletter -->
        <section class="newsletter-demo">
            <div class="container">
                <div class="newsletter-box">
                    <h2>Bleiben Sie informiert</h2>
                    <p>Erhalten Sie regelmäßige Updates über unsere Projekte und Erfolge.</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Ihre E-Mail-Adresse" required>
                        <button type="submit" class="btn btn-primary">Anmelden</button>
                    </form>
                </div>
            </div>
        </section>

        <?php
    }
    ?>
</div>

<style>
/* Demo-Styles für die Beispiel-Blöcke */
.verein-homepage {
    --primary-color: #2c5aa0;
    --secondary-color: #f4a261;
    --accent-color: #e76f51;
    --text-color: #333;
    --light-bg: #f8f9fa;
}

.hero-section-demo {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 100px 0;
    text-align: center;
}

.hero-section-demo h1 {
    font-size: 3rem;
    margin-bottom: 1rem;
}

.hero-buttons {
    margin-top: 2rem;
}

.hero-buttons .btn {
    margin: 0 0.5rem;
}

.wichtige-zahlen-demo {
    padding: 80px 0;
    background: var(--light-bg);
}

.zahlen-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 2rem;
    text-align: center;
}

.zahl-item .zahl {
    display: block;
    font-size: 3rem;
    font-weight: bold;
    color: var(--primary-color);
}

.zahl-item .beschreibung {
    font-size: 1.1rem;
    color: var(--text-color);
}

.projekte-demo, .mitmachen-demo, .testimonials-demo {
    padding: 80px 0;
}

.projekt-grid, .mitmach-optionen {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.projekt-karte, .mitmach-karte {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.projekt-karte:hover, .mitmach-karte:hover {
    transform: translateY(-5px);
}

.fortschritt-balken {
    width: 100%;
    height: 10px;
    background: #e0e0e0;
    border-radius: 5px;
    overflow: hidden;
    margin: 1rem 0 0.5rem;
}

.fortschritt-fill {
    height: 100%;
    background: var(--primary-color);
    transition: width 0.3s ease;
}

.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
}

.testimonial {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-left: 4px solid var(--primary-color);
}

.testimonial cite {
    display: block;
    margin-top: 1rem;
    font-style: italic;
    color: #666;
}

.newsletter-demo {
    background: var(--primary-color);
    color: white;
    padding: 80px 0;
}

.newsletter-box {
    text-align: center;
    max-width: 600px;
    margin: 0 auto;
}

.newsletter-form {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

.newsletter-form input {
    flex: 1;
    padding: 0.75rem;
    border: none;
    border-radius: 5px;
}

.btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-secondary {
    background: var(--secondary-color);
    color: white;
}

.btn-outline {
    background: transparent;
    color: var(--primary-color);
    border: 2px solid var(--primary-color);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}

section h2 {
    text-align: center;
    font-size: 2.5rem;
    margin-bottom: 1rem;
    color: var(--primary-color);
}

@media (max-width: 768px) {
    .hero-section-demo h1 {
        font-size: 2rem;
    }
    
    .newsletter-form {
        flex-direction: column;
    }
    
    .zahlen-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<?php get_footer(); ?>
