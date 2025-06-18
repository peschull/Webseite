<?php
/**
 * Template für die Team Karte mit Hover Biografie
 *
 * @package Verein_Menschlichkeit
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Hole Block-Felder
$team_members = get_field('team_members');

if ($team_members) : ?>
<div class="team-cards-container">
    <?php foreach ($team_members as $member) : 
        $image = $member['image'];
        $name = $member['name'];
        $position = $member['position'];
        $bio = $member['bio'];
        $social_links = $member['social_links'];
    ?>
        <div class="team-card">
            <div class="team-card-front">
                <?php if ($image) : ?>
                    <div class="team-member-image">
                        <img src="<?php echo esc_url($image['url']); ?>" 
                             alt="<?php echo esc_attr($name); ?>" 
                             loading="lazy">
                    </div>
                <?php endif; ?>
                
                <div class="team-member-info">
                    <h3 class="team-member-name"><?php echo esc_html($name); ?></h3>
                    <?php if ($position) : ?>
                        <p class="team-member-position"><?php echo esc_html($position); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="team-card-back">
                <div class="team-member-bio">
                    <?php echo wp_kses_post($bio); ?>
                </div>
                
                <?php if ($social_links) : ?>
                    <div class="team-member-social">
                        <?php foreach ($social_links as $link) : ?>
                            <a href="<?php echo esc_url($link['url']); ?>" 
                               class="social-link <?php echo esc_attr($link['platform']); ?>"
                               target="_blank" 
                               rel="noopener noreferrer"
                               aria-label="<?php echo sprintf(esc_attr__('Besuche %s auf %s', 'verein-menschlichkeit'), $name, $link['platform']); ?>">
                                <i class="fab fa-<?php echo esc_attr($link['platform']); ?>"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
