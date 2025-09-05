<div id="toast" class="fixed top-6 right-6 bg-white text-black shadow-xl rounded-lg px-4 py-3 z-50 hidden border-l-4 border-pink-500">
    <span id="toast-message"></span>
</div>

<script>
    window.showToast = function(message) {
        const toast = document.getElementById('toast');
        const msg = document.getElementById('toast-message');
        msg.textContent = message;

        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 4000);
    }
</script>
