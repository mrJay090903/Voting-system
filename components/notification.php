<?php
function showNotification($message, $type = 'success') {
    $bgColor = $type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
    $icon = $type === 'success' ? 'check-circle' : 'x-circle';
    
    return <<<HTML
    <div class="notification-container fixed top-4 right-4 z-50 animate-fade-in-down" id="notification">
        <div class="$bgColor border-l-4 p-4 rounded shadow-md flex items-center justify-between max-w-md">
            <div class="flex items-center">
                <i class="fas fa-$icon mr-2"></i>
                <p>$message</p>
            </div>
            <button onclick="this.parentElement.remove()" class="ml-4 text-current hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <script>
        setTimeout(() => {
            const notification = document.getElementById('notification');
            if (notification) {
                notification.classList.add('animate-fade-out');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }
        }, 3000);
    </script>
HTML;
}
?>

<style>
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }
    .animate-fade-in-down {
        animation: fadeInDown 0.5s ease-out;
    }
    .animate-fade-out {
        animation: fadeOut 0.3s ease-out forwards;
    }
</style> 