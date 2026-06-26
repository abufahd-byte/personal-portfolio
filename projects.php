<?php
require_once 'config/config.php';
require_once 'includes/header.php';
require_once 'includes/navbar.php';

$projects = $pdo->query("SELECT * FROM projects WHERE status = 'active' ORDER BY sort_order ASC")->fetchAll();

$categories = [];
foreach ($projects as $p) {
    $cat = trim($p->{'category_'.$lang});
    if ($cat && !in_array($cat, $categories)) $categories[] = $cat;
}
?>

<div class="page-header">
  <div class="container">
    <span class="section-badge"><i class="fa-solid fa-rocket"></i> <?= __('section_projects_subtitle') ?></span>
    <h1 class="section-title"><?= __('section_projects_title') ?></h1>
  </div>
</div>

<section class="section">
  <div class="container">

    <!-- Filters -->
    <div class="filter-bar reveal">
      <button class="filter-btn active" data-filter="all"><?= __('filter_all') ?></button>
      <?php foreach ($categories as $cat): ?>
      <button class="filter-btn" data-filter="<?= e($cat) ?>"><?= e($cat) ?></button>
      <?php endforeach; ?>
    </div>

    <!-- Grid -->
    <div class="projects-grid">
      <?php if (empty($projects)): ?>
        <div style="grid-column:1/-1; text-align:center; padding:3rem; color:var(--text-muted);">
          <i class="fa-solid fa-folder-open" style="font-size:3rem; opacity:0.3; margin-bottom:1rem; display:block;"></i>
          <p><?= $lang == 'ar' ? 'لا توجد مشاريع حالياً' : 'No projects yet' ?></p>
        </div>
      <?php endif; ?>

      <?php $d = 0; foreach ($projects as $proj): ?>
      <div class="project-card reveal delay-<?= $d % 3 ?>" data-category="<?= e($proj->{'category_'.$lang}) ?>">
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
            <a href="project-details.php?id=<?= $proj->id ?>" class="btn btn-outline btn-sm"><i class="fa-solid fa-eye"></i> <?= __('btn_details') ?? 'Details' ?></a>
            <?php if ($proj->project_link): ?>
              <a href="<?= e($proj->project_link) ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa-solid fa-arrow-up-right-from-square"></i> <?= __('btn_preview') ?? 'Live' ?></a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php $d++; endforeach; ?>
    </div>

  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
