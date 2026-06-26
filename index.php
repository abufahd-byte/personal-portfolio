<?php
require_once 'config/config.php';
require_once 'includes/header.php';
require_once 'includes/navbar.php';

// Fetch all dynamic content
$hero = $pdo->query("SELECT * FROM hero_sections WHERE id = 1")->fetch();
$about = $pdo->query("SELECT * FROM about_sections WHERE id = 1")->fetch();
$skills = $pdo->query("SELECT * FROM skills WHERE status = 'active' ORDER BY category, sort_order ASC")->fetchAll();
$services = $pdo->query("SELECT * FROM services WHERE status = 'active' ORDER BY sort_order ASC")->fetchAll();
$featured_projects = $pdo->query("SELECT * FROM projects WHERE status = 'active' AND is_featured = 1 ORDER BY sort_order ASC LIMIT 6")->fetchAll();
if (empty($featured_projects)) {
    $featured_projects = $pdo->query("SELECT * FROM projects WHERE status = 'active' ORDER BY id DESC LIMIT 6")->fetchAll();
}
$processes = $pdo->query("SELECT * FROM work_process ORDER BY sort_order ASC, step_number ASC")->fetchAll();
$gallery_items = $pdo->query("SELECT * FROM gallery WHERE status = 'active' ORDER BY sort_order ASC")->fetchAll();
$testimonials = $pdo->query("SELECT * FROM testimonials WHERE status = 'active' ORDER BY sort_order ASC")->fetchAll();
$recent_posts = $pdo->query("SELECT * FROM blog_posts WHERE status = 'Published' ORDER BY created_at DESC LIMIT 3")->fetchAll();

$skills_by_cat = [];
foreach ($skills as $s) { $skills_by_cat[$s->category][] = $s; }


$hero_img = ($hero && $hero->image && file_exists(ROOT_PATH . 'uploads/hero/' . $hero->image)) ? BASE_URL . 'uploads/hero/' . $hero->image : null;
?>

<!-- ═══════════ HERO ═══════════ -->
<?php if ($hero && $hero->is_active): ?>
<section id="home" class="hero" <?= $hero_img ? 'style="background: url(\''.e($hero_img).'\') center/cover no-repeat;"' : '' ?>>
  <?php if ($hero_img): ?>
  <div style="position:absolute; inset:0; background:rgba(15, 23, 42, 0.85); z-index:0;"></div>
  <?php endif; ?>
  <!-- Animated Background Elements -->
  <div class="hero-shape shape-1" style="z-index:0;"></div>
  <div class="hero-shape shape-2" style="z-index:0;"></div>
  <div class="hero-grid" style="z-index:0;"></div>

  <div class="container">
    <div class="hero-content">
      <div class="hero-badge reveal">
        <span class="pulse-dot"></span>
        <?= e($hero->{'title_'.$lang}) ?>
      </div>

      <h1 class="hero-title reveal delay-1">
        <?= e($developer_name) ?>
      </h1>
      
      <h2 class="hero-subtitle reveal delay-2">
        <span id="typewriter" data-text="<?= e($hero->{'subtitle_'.$lang}) ?>"></span><span class="cursor"></span>
      </h2>

      <p class="hero-desc reveal delay-3">
        <?= e($hero->{'description_'.$lang}) ?>
      </p>

      <div class="hero-actions reveal delay-4">
        <?php if ($hero->{'btn1_text_'.$lang}): ?>
        <a href="<?= e($hero->btn1_url) ?>" class="btn btn-primary">
          <?= e($hero->{'btn1_text_'.$lang}) ?> <i class="fa-solid fa-arrow-<?= $lang == 'ar' ? 'left' : 'right' ?>"></i>
        </a>
        <?php endif; ?>

        <?php if ($hero->{'btn2_text_'.$lang}): ?>
        <a href="<?= e($hero->btn2_url) ?>" class="btn btn-outline">
          <?= e($hero->{'btn2_text_'.$lang}) ?>
        </a>
        <?php endif; ?>
      </div>

      <!-- Socials -->
      <div class="hero-socials reveal delay-5">
        <span class="social-label"><?= $lang == 'ar' ? 'تابعني:' : 'Follow Me:' ?></span>
        <?php if ($settings->github_link): ?>
        <a href="<?= e($settings->github_link) ?>" target="_blank" class="social-icon"><i class="fa-brands fa-github"></i></a>
        <?php endif; ?>
        <?php if ($settings->linkedin_link): ?>
        <a href="<?= e($settings->linkedin_link) ?>" target="_blank" class="social-icon"><i class="fa-brands fa-linkedin-in"></i></a>
        <?php endif; ?>
        <?php if ($settings->whatsapp): ?>
        <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $settings->whatsapp) ?>" target="_blank" class="social-icon"><i class="fa-brands fa-whatsapp"></i></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ═══════════ ABOUT ═══════════ -->
<?php if ($about && $about->is_active): ?>
<section id="about" class="section bg-light">
  <div class="container">
    <div class="about-wrapper">
      <div class="about-image-col reveal">
        <div class="about-image-container">
          <?php 
          $about_img = ($about && $about->image && file_exists(ROOT_PATH . 'uploads/about/' . $about->image)) ? BASE_URL . 'uploads/about/' . $about->image : null;
          if ($about_img): ?>
            <img src="<?= $about_img ?>" alt="<?= e($developer_name) ?>" class="about-img">
          <?php else: ?>
            <div class="about-img-placeholder"><i class="fa-solid fa-user"></i></div>
          <?php endif; ?>
          <div class="experience-badge">
            <span class="exp-num"><?= $about->years_experience ?? 0 ?>+</span>
            <span class="exp-text"><?= $lang == 'ar' ? 'سنوات<br>خبرة' : 'Years<br>Experience' ?></span>
          </div>
        </div>
      </div>

      <div class="about-text-col reveal delay-2">
        <div class="section-title-wrap">
          <span class="subtitle"><?= __('section_about_subtitle') ?></span>
          <h2 class="title"><?= e($about->{'title_'.$lang}) ?></h2>
        </div>
        
        <p class="about-lead"><?= e($settings->{'short_description_'.$lang}) ?></p>
        <p class="about-desc"><?= e($about->{'description_'.$lang}) ?></p>

        <!-- Stats -->
        <div class="about-stats">
          <div class="stat-box">
            <h3 class="stat-number"><?= $about->projects_completed ?? 0 ?>+</h3>
            <p class="stat-name"><?= __('stats_projects') ?></p>
          </div>
          <div class="stat-box">
            <h3 class="stat-number"><?= $about->happy_clients ?? 0 ?>+</h3>
            <p class="stat-name"><?= __('stats_clients') ?></p>
          </div>
        </div>

        <?php if ($settings->cv_file): ?>
        <div class="about-cta">
          <a href="<?= BASE_URL ?>uploads/cv/<?= $settings->cv_file ?>" download class="btn btn-primary">
            <i class="fa-solid fa-download"></i> <?= __('btn_download_cv') ?>
          </a>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ═══════════ SKILLS ═══════════ -->
<section id="skills" class="section">
  <div class="container">
    <div class="section-title-wrap text-center reveal">
      <span class="subtitle"><?= __('section_skills_subtitle') ?></span>
      <h2 class="title"><?= __('section_skills_title') ?></h2>
    </div>

    <div class="skills-container">
      <?php $d = 0; foreach ($skills_by_cat as $cat => $items): ?>
      <div class="skill-category reveal delay-<?= $d % 3 ?>">
        <h3 class="cat-title"><?= e($cat) ?></h3>
        <div class="cat-items">
          <?php foreach ($items as $sk): ?>
          <div class="skill-item">
            <?php if ($sk->icon): ?><i class="<?= e($sk->icon) ?>"></i><?php endif; ?>
            <span><?= e($sk->{'name_'.$lang}) ?></span>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php $d++; endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════ SERVICES ═══════════ -->
<section id="services" class="section bg-light">
  <div class="container">
    <div class="section-title-wrap text-center reveal">
      <span class="subtitle"><?= __('section_services_subtitle') ?></span>
      <h2 class="title"><?= __('section_services_title') ?></h2>
    </div>

    <div class="services-grid">
      <?php $d = 0; foreach ($services as $srv): ?>
      <div class="service-card reveal delay-<?= $d % 3 ?>">
        <?php if ($srv->image && file_exists(ROOT_PATH . 'uploads/services/' . $srv->image)): ?>
          <img src="<?= BASE_URL ?>uploads/services/<?= $srv->image ?>" alt="<?= e($srv->{'title_'.$lang}) ?>" class="srv-img" style="width:100%; height:auto; border-radius:8px; margin-bottom:15px; max-height:200px; object-fit:cover;">
        <?php endif; ?>
        <div class="srv-icon"><i class="<?= e($srv->icon) ?>"></i></div>
        <h3 class="srv-title"><?= e($srv->{'title_'.$lang}) ?></h3>
        <p class="srv-desc"><?= e($srv->{'description_'.$lang}) ?></p>
      </div>
      <?php $d++; endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══════════ PROJECTS ═══════════ -->
<section id="projects" class="section">
  <div class="container">
    <div class="section-title-wrap text-center reveal">
      <span class="subtitle"><?= __('section_projects_subtitle') ?></span>
      <h2 class="title"><?= __('section_projects_title') ?></h2>
    </div>

    <div class="projects-grid">
      <?php $d = 0; foreach ($featured_projects as $proj): ?>
      <div class="project-card reveal delay-<?= $d % 3 ?>">
        <div class="project-image-wrap">
          <?php if ($proj->image && file_exists(ROOT_PATH . 'uploads/projects/' . $proj->image)): ?>
            <img src="<?= BASE_URL ?>uploads/projects/<?= $proj->image ?>" alt="<?= e($proj->{'title_'.$lang}) ?>" loading="lazy" decoding="async" class="project-image">
          <?php else: ?>
            <div class="project-placeholder"><i class="fa-solid fa-code"></i></div>
          <?php endif; ?>
        </div>
        <div class="project-content">
          <span style="font-size: 0.8rem; color: var(--primary-color); font-weight: 700; text-transform: uppercase; margin-bottom: 0.5rem; display: block;"><?= e($proj->{'category_'.$lang}) ?></span>
          <h3 class="project-title"><a href="project-details.php?id=<?= $proj->id ?>"><?= e($proj->{'title_'.$lang}) ?></a></h3>
          <p class="project-description"><?= e($proj->{'description_'.$lang}) ?></p>
          <div class="project-tags">
            <?php foreach (explode(',', $proj->{'technologies_'.$lang}) as $tag): ?>
            <span class="project-tag"><?= e(trim($tag)) ?></span>
            <?php endforeach; ?>
          </div>
          <div class="project-actions">
            <a href="project-details.php?id=<?= $proj->id ?>" class="btn btn-outline btn-sm"><i class="fa-solid fa-eye"></i> Details</a>
            <?php if ($proj->project_link): ?>
              <a href="<?= e($proj->project_link) ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa-solid fa-arrow-up-right-from-square"></i> Live</a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php $d++; endforeach; ?>
    </div>

    <div class="text-center reveal" style="margin-top: 3rem;">
      <a href="projects.php" class="btn btn-outline"><?= __('btn_all_projects') ?></a>
    </div>
  </div>
</section>

<!-- ═══════════ WORK PROCESS ═══════════ -->
<?php if (count($processes) > 0): ?>
<section id="process" class="section bg-light">
  <div class="container">
    <div class="section-title-wrap text-center reveal">
      <span class="subtitle"><?= __('section_process_subtitle') ?></span>
      <h2 class="title"><?= __('section_process_title') ?></h2>
    </div>

    <div class="process-steps">
      <?php foreach ($processes as $step): ?>
      <div class="process-step reveal">
        <div class="step-num"><?= sprintf('%02d', $step->step_number) ?></div>
        <h3 class="step-title"><?= e($step->{'title_'.$lang}) ?></h3>
        <p class="step-desc"><?= e($step->{'description_'.$lang}) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ═══════════ GALLERY ═══════════ -->
<?php if (count($gallery_items) > 0): ?>
<section id="showcase" class="section">
  <div class="container">
    <div class="section-title-wrap text-center reveal">
      <span class="subtitle"><?= __('section_gallery_subtitle') ?></span>
      <h2 class="title"><?= __('section_gallery_title') ?></h2>
    </div>

    <div class="gallery-grid">
      <?php $d = 0; foreach ($gallery_items as $item): ?>
      <div class="gallery-item reveal delay-<?= $d % 3 ?>">
        <img src="<?= BASE_URL ?>uploads/gallery/<?= $item->image ?>" alt="<?= e($item->{'title_'.$lang}) ?>" loading="lazy" decoding="async">
        <div class="gallery-caption">
          <h4><?= e($item->{'title_'.$lang}) ?></h4>
        </div>
      </div>
      <?php $d++; endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ═══════════ TESTIMONIALS ═══════════ -->
<?php if (count($testimonials) > 0): ?>
<section id="testimonials" class="section bg-light">
  <div class="container">
    <div class="section-title-wrap text-center reveal">
      <span class="subtitle"><?= __('section_testimonials_subtitle') ?></span>
      <h2 class="title"><?= __('section_testimonials_title') ?></h2>
    </div>

    <div class="testimonials-grid">
      <?php $d = 0; foreach ($testimonials as $t): ?>
      <div class="testi-card reveal delay-<?= $d % 3 ?>">
        <div class="testi-icon"><i class="fa-solid fa-quote-left"></i></div>
        <p class="testi-text">"<?= e($t->{'review_text_'.$lang}) ?>"</p>
        <div class="testi-author">
          <?php if ($t->client_image && file_exists(ROOT_PATH . 'uploads/profile/' . $t->client_image)): ?>
            <img src="<?= BASE_URL ?>uploads/profile/<?= $t->client_image ?>" alt="" class="testi-avatar">
          <?php else: ?>
            <div class="testi-avatar-placeholder"><i class="fa-solid fa-user"></i></div>
          <?php endif; ?>
          <div class="testi-info">
            <h4><?= e($t->{'client_name_'.$lang}) ?></h4>
            <span><?= e($t->{'client_position_'.$lang}) ?></span>
          </div>
        </div>
      </div>
      <?php $d++; endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- ═══════════ BLOG ═══════════ -->
<?php if (count($recent_posts) > 0): ?>
<section id="blog" class="section">
  <div class="container">
    <div class="section-title-wrap text-center reveal">
      <span class="subtitle"><?= __('section_blog_subtitle') ?></span>
      <h2 class="title"><?= __('section_blog_title') ?></h2>
    </div>

    <div class="blog-grid">
      <?php $d = 0; foreach ($recent_posts as $post): ?>
      <div class="blog-card reveal delay-<?= $d % 3 ?>">
        <div class="blog-img">
          <?php if ($post->image && file_exists(ROOT_PATH . 'uploads/blog/' . $post->image)): ?>
            <img src="<?= BASE_URL ?>uploads/blog/<?= $post->image ?>" alt="<?= e($post->{'title_'.$lang}) ?>" loading="lazy" decoding="async">
          <?php else: ?>
            <div class="project-placeholder"><i class="fa-solid fa-newspaper"></i></div>
          <?php endif; ?>
        </div>
        <div class="blog-content">
          <div class="blog-meta">
            <span><i class="fa-regular fa-calendar"></i> <?= date('d M Y', strtotime($post->created_at)) ?></span>
            <span><i class="fa-regular fa-user"></i> <?= e($post->author) ?></span>
          </div>
          <h3 class="blog-title"><a href="blog-details.php?slug=<?= $post->slug ?>"><?= e($post->{'title_'.$lang}) ?></a></h3>
          <p class="blog-excerpt"><?= e(mb_substr($post->{'short_description_'.$lang}, 0, 90)) ?>...</p>
          <a href="blog-details.php?slug=<?= $post->slug ?>" class="blog-link"><?= __('read_more') ?> <i class="fa-solid fa-arrow-<?= $lang == 'ar' ? 'left' : 'right' ?>"></i></a>
        </div>
      </div>
      <?php $d++; endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
