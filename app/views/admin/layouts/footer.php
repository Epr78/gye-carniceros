</main>

<footer style="background:#111; color:#fff; text-align:center; padding:16px; margin-top:40px;">
    <p style="margin:0;">Panel de administración - GyE Carniceros</p>
</footer>

<script>
window.addEventListener('pageshow', function (event) {
    const nav = performance.getEntriesByType("navigation")[0];

    if (event.persisted || (nav && nav.type === "back_forward")) {
        window.location.href = "<?= BASE_URL ?>/admin.php?route=login";
    }
});
</script>

</body>
</html>