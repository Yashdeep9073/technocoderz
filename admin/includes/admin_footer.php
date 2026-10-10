  </div><!-- /adm-content -->
</main><!-- /adm-main -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Auto-dismiss alerts
document.querySelectorAll('.adm-alert[data-auto-dismiss]').forEach(el => {
  setTimeout(() => el.remove(), parseInt(el.dataset.autoDismiss) || 4000);
});

// Confirm delete
document.querySelectorAll('[data-confirm]').forEach(el => {
  el.addEventListener('click', function(e) {
    if (!confirm(this.dataset.confirm || 'Are you sure?')) e.preventDefault();
  });
});
</script>
</body>
</html>
