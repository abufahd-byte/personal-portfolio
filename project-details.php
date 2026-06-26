<?php
require_once 'config/config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) { header("Location: projects.php"); exit; }

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = :id AND status = 'active'");
$stmt->execute([':id' => $id]);
$project = $stmt->fetch();

if (!$project) { header("Location: projects.php"); exit; }

require_once 'includes/header.php';
require_once 'includes/navbar.php';
?>

<div class="page-header">
  <div class="container">
    <span class="section-badge"><i class="fa-solid fa-folder-open"></i> <?= __('project_category') ?></span>
    <h1 class="section-title"><?= e($project->{'title_'.$lang}) ?></h1>
  </div>
</div>

<section class="section">
  <div class="container">
    <div style="margin-bottom:1.5rem;">
      <a href="projects.php" class="btn btn-outline btn-sm">
        <i class="fa-solid fa-arrow-<?= $lang == 'ar' ? 'right' : 'left' ?>"></i> <?= __('back_to_projects') ?>
      </a>
    </div>

    <div class="project-details-layout">
      <!-- Main -->
      <div class="reveal">
        <div class="project-details-hero">
          <?php if ($project->image && file_exists(ROOT_PATH . 'uploads/projects/' . $project->image)): ?>
            <img src="<?= BASE_URL ?>uploads/projects/<?= $project->image ?>" alt="<?= e($project->{'title_'.$lang}) ?>" class="project-details-img">
          <?php else: ?>
            <div class="project-details-placeholder"><i class="fa-solid fa-code"></i></div>
          <?php endif; ?>
        </div>

        <h3 style="font-size:1.5rem; margin-bottom:1rem;"><?= __('project_overview') ?></h3>
        <div style="background:var(--bg-card); padding:2rem; border-radius:var(--radius-lg); border:1px solid var(--border); line-height:2; color:var(--text-secondary); white-space:pre-line;">
          <?= e($project->{'description_'.$lang}) ?>
        </div>
      </div>

      <!-- Sidebar -->
      <div class="reveal delay-1" style="position:sticky; top:100px;">
        <div style="background:var(--bg-card); padding:2rem; border-radius:var(--radius-xl); border:1px solid var(--border);">
          <h2 style="font-size:1.3rem; color:var(--primary); margin-bottom:1.5rem;"><?= e($project->{'title_'.$lang}) ?></h2>

          <div style="margin-bottom:1.2rem; padding-bottom:1.2rem; border-bottom:1px solid var(--border);">
            <p style="font-weight:600; color:var(--text-primary); margin-bottom:0.3rem;">
              <i class="fa-solid fa-folder-open" style="color:var(--text-muted); margin-inline-end:0.5rem;"></i> <?= __('project_category') ?>
            </p>
            <p style="color:var(--text-muted);"><?= e($project->{'category_'.$lang}) ?></p>
          </div>

          <div style="margin-bottom:1.5rem;">
            <p style="font-weight:600; color:var(--text-primary); margin-bottom:0.8rem;">
              <i class="fa-solid fa-layer-group" style="color:var(--text-muted); margin-inline-end:0.5rem;"></i> <?= __('project_tech') ?>
            </p>
            <div style="display:flex; flex-wrap:wrap; gap:0.4rem;">
              <?php foreach (explode(',', $project->{'technologies_'.$lang}) as $tag): ?>
              <span class="skill-tag"><?= e(trim($tag)) ?></span>
              <?php endforeach; ?>
            </div>
          </div>

          <div style="display:flex; flex-direction:column; gap:0.8rem;">
            <?php if ($project->project_link): ?>
            <a href="<?= e($project->project_link) ?>" target="_blank" class="btn btn-primary" style="width:100%;">
              <i class="fa-solid fa-arrow-up-right-from-square"></i> <?= __('btn_preview') ?>
            </a>
            <?php endif; ?>
            <?php if ($project->github_link): ?>
            <a href="<?= e($project->github_link) ?>" target="_blank" class="btn btn-outline" style="width:100%;">
              <i class="fa-brands fa-github"></i> <?= __('btn_code') ?>
            </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
