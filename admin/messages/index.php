<?php
require_once __DIR__ . '/../../includes/functions.php';
requireAdminLogin();
$pdo=getDB();$csrf=generateCsrfToken();

// Mark as read
if(isset($_GET['read'])){
  $pdo->prepare("UPDATE contact_messages SET is_read=1 WHERE id=?")->execute([(int)$_GET['read']]);
  header('Location: index.php');exit;
}
// Mark unread
if(isset($_GET['unread'])){
  $pdo->prepare("UPDATE contact_messages SET is_read=0 WHERE id=?")->execute([(int)$_GET['unread']]);
  header('Location: index.php');exit;
}
// Delete
if(isset($_GET['delete'])){
  if(!verifyCsrfToken($_GET['csrf']??'')){setFlash('danger','CSRF error.');header('Location: index.php');exit;}
  $pdo->prepare("DELETE FROM contact_messages WHERE id=?")->execute([(int)$_GET['delete']]);
  setFlash('success','Message deleted.');header('Location: index.php');exit;
}

$filter=$_GET['filter']??'all';
$where = $filter==='unread' ? "WHERE is_read=0" : ($filter==='read' ? "WHERE is_read=1" : '');
$messages=$pdo->query("SELECT * FROM contact_messages $where ORDER BY created_at DESC")->fetchAll();
$adminPageTitle='Contact Messages';$adminActive='messages';
require_once __DIR__ . '/../includes/admin_header.php';
?>
<?php $f=getFlash();if($f):?><div class="adm-alert adm-alert-<?=$f['type']==='success'?'success':'danger'?>" data-auto-dismiss="4000"><i class="bi bi-check-circle-fill"></i><?=e($f['message'])?></div><?php endif;?>

<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
  <h2 style="font-family:'Space Grotesk',sans-serif;font-size:1.2rem;font-weight:700;color:#fff;margin:0;">
    Messages (<?=count($messages)?>)
  </h2>
  <div style="display:flex;gap:8px;">
    <a href="?filter=all"    class="adm-btn adm-btn-sm <?=$filter==='all'?'adm-btn-primary':'adm-btn-outline'?>">All</a>
    <a href="?filter=unread" class="adm-btn adm-btn-sm <?=$filter==='unread'?'adm-btn-primary':'adm-btn-outline'?>">Unread</a>
    <a href="?filter=read"   class="adm-btn adm-btn-sm <?=$filter==='read'?'adm-btn-primary':'adm-btn-outline'?>">Read</a>
  </div>
</div>

<div class="adm-card">
  <div style="overflow-x:auto;">
    <table class="adm-table">
      <thead>
        <tr><th></th><th>From</th><th>Subject</th><th>Date</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php if($messages): foreach($messages as $msg): ?>
        <tr style="<?=!$msg['is_read']?'background:rgba(108,63,245,0.04)':''?>">
          <td style="width:24px;">
            <?php if(!$msg['is_read']):?>
            <span style="width:8px;height:8px;background:var(--adm-primary);border-radius:50%;display:inline-block;" title="Unread"></span>
            <?php endif;?>
          </td>
          <td>
            <div style="font-weight:<?=!$msg['is_read']?'700':'500'?>;color:#fff;"><?=e($msg['name'])?></div>
            <div style="font-size:0.72rem;color:var(--adm-muted);"><?=e($msg['email'])?></div>
          </td>
          <td>
            <div style="font-size:0.87rem;color:var(--adm-text);font-weight:<?=!$msg['is_read']?'600':'400'?>;">
              <?=e($msg['subject'] ?: 'No Subject')?>
            </div>
            <div style="font-size:0.75rem;color:var(--adm-muted);margin-top:2px;">
              <?=e(substr($msg['message'], 0, 80))?>...
            </div>
          </td>
          <td style="font-size:0.78rem;color:var(--adm-muted);white-space:nowrap;">
            <?=date('d M Y', strtotime($msg['created_at']))?>
            <div style="font-size:0.7rem;"><?=date('h:i A', strtotime($msg['created_at']))?></div>
          </td>
          <td>
            <div style="display:flex;gap:6px;flex-wrap:nowrap;">
              <!-- Toggle read/unread -->
              <?php if(!$msg['is_read']):?>
              <a href="?read=<?=$msg['id']?>" class="adm-btn adm-btn-sm adm-btn-outline" title="Mark as read">
                <i class="bi bi-envelope-open"></i>
              </a>
              <?php else:?>
              <a href="?unread=<?=$msg['id']?>" class="adm-btn adm-btn-sm adm-btn-outline" title="Mark as unread">
                <i class="bi bi-envelope-fill"></i>
              </a>
              <?php endif;?>
              <!-- Reply -->
              <a href="mailto:<?=e($msg['email'])?>" class="adm-btn adm-btn-sm adm-btn-primary" title="Reply"><i class="bi bi-reply-fill"></i></a>
              <!-- Delete -->
              <a href="?delete=<?=$msg['id']?>&csrf=<?=urlencode($csrf)?>" class="adm-btn adm-btn-sm adm-btn-danger" onclick="return confirm('Delete this message?')" title="Delete"><i class="bi bi-trash-fill"></i></a>
            </div>
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="5" style="text-align:center;padding:48px;color:var(--adm-muted);">
          <i class="bi bi-inbox" style="font-size:2.5rem;display:block;margin-bottom:10px;opacity:0.4;"></i>
          No messages found.
        </td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/admin_footer.php'; ?>
