<?php
require_once 'config/config.php';

$success_msg = '';
$error_msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error_msg = __('msg_error_empty');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = __('msg_error_email');
    } else {
        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (:n, :e, :s, :m)");
        if ($stmt->execute([':n' => $name, ':e' => $email, ':s' => $subject, ':m' => $message])) {
            $success_msg = __('msg_success');
        } else {
            $error_msg = __('msg_error_send');
        }
    }
}

require_once 'includes/header.php';
require_once 'includes/navbar.php';
?>

<div class="page-header">
  <div class="container">
    <span class="section-badge"><i class="fa-solid fa-paper-plane"></i> <?= __('section_contact_subtitle') ?></span>
    <h1 class="section-title"><?= __('section_contact_title') ?></h1>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="contact-grid">

      <!-- Info Side -->
      <div class="reveal">
        <h3 style="font-size:1.5rem; margin-bottom:1rem;"><?= __('contact_info_title') ?></h3>
        <p style="color:var(--text-muted); margin-bottom:2rem; line-height:1.8;"><?= __('contact_info_desc') ?></p>

        <?php if ($settings->email): ?>
        <div class="contact-info-card">
          <div class="contact-info-icon"><i class="fa-solid fa-envelope"></i></div>
          <div>
            <p style="font-weight:600; font-size:0.85rem; color:var(--text-muted); margin:0;"><?= __('contact_email_lbl') ?></p>
            <p style="color:var(--text-primary); margin:0;" dir="ltr"><?= e($settings->email) ?></p>
          </div>
        </div>
        <?php endif; ?>

        <?php if ($settings->whatsapp): ?>
        <div class="contact-info-card">
          <div class="contact-info-icon" style="color:#25D366;"><i class="fa-brands fa-whatsapp"></i></div>
          <div>
            <p style="font-weight:600; font-size:0.85rem; color:var(--text-muted); margin:0;"><?= __('contact_wa_lbl') ?></p>
            <p style="color:var(--text-primary); margin:0;" dir="ltr"><?= e($settings->whatsapp) ?></p>
          </div>
        </div>
        <?php endif; ?>

        <?php if ($settings->location_en || $settings->location_ar): ?>
        <div class="contact-info-card">
          <div class="contact-info-icon"><i class="fa-solid fa-location-dot"></i></div>
          <div>
            <p style="color:var(--text-primary); margin:0;"><?= e($settings->{'location_'.$lang}) ?></p>
          </div>
        </div>
        <?php endif; ?>

        <h4 style="margin-top:2rem; margin-bottom:1rem; font-size:1rem;"><?= __('contact_social_lbl') ?></h4>
        <div style="display:flex; gap:0.6rem;">
          <?php if ($settings->github_link): ?>
          <a href="<?= e($settings->github_link) ?>" target="_blank" class="icon-btn"><i class="fa-brands fa-github"></i></a>
          <?php endif; ?>
          <?php if ($settings->linkedin_link): ?>
          <a href="<?= e($settings->linkedin_link) ?>" target="_blank" class="icon-btn"><i class="fa-brands fa-linkedin-in"></i></a>
          <?php endif; ?>
          <?php if ($settings->facebook_link): ?>
          <a href="<?= e($settings->facebook_link) ?>" target="_blank" class="icon-btn"><i class="fa-brands fa-facebook-f"></i></a>
          <?php endif; ?>
          <?php if ($settings->twitter_link): ?>
          <a href="<?= e($settings->twitter_link) ?>" target="_blank" class="icon-btn"><i class="fa-brands fa-twitter"></i></a>
          <?php endif; ?>
        </div>
      </div>

      <!-- Form Side -->
      <div class="contact-form-card reveal delay-1">
        <?php if ($success_msg): ?>
        <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i> <?= $success_msg ?></div>
        <?php endif; ?>
        <?php if ($error_msg): ?>
        <div class="alert alert-error"><i class="fa-solid fa-circle-exclamation"></i> <?= $error_msg ?></div>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>contact.php" method="POST">
          <div class="form-row">
            <div class="form-group">
              <label><?= __('form_name') ?></label>
              <input type="text" name="name" class="form-control" placeholder="<?= __('form_name_ph') ?>" required>
            </div>
            <div class="form-group">
              <label><?= __('form_email') ?></label>
              <input type="email" name="email" class="form-control" placeholder="<?= __('form_email_ph') ?>" required dir="ltr">
            </div>
          </div>
          <div class="form-group">
            <label><?= __('form_subject') ?></label>
            <input type="text" name="subject" class="form-control" placeholder="<?= __('form_subject_ph') ?>" required>
          </div>
          <div class="form-group">
            <label><?= __('form_message') ?></label>
            <textarea name="message" class="form-control" rows="5" placeholder="<?= __('form_message_ph') ?>" required></textarea>
          </div>
          <button type="submit" class="btn btn-primary" style="width:100%;">
            <i class="fa-solid fa-paper-plane"></i> <?= __('btn_send_message') ?>
          </button>
        </form>
      </div>

    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>
