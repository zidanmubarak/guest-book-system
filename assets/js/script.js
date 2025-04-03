/**
 * Main Script
 * Contains general JavaScript functions for the application
 */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    initializeTooltips();
    
    // Initialize DataTables
    initializeDataTables();
    
    // Initialize Select2
    initializeSelect2();
    
    // Toggle sidebar on mobile
    initializeSidebarToggle();
    
    // Toggle password visibility
    initializePasswordToggle();
    
    // Auto-close alerts after 5 seconds
    initializeAlertAutoDismiss();
    
    /**
     * Initialize Bootstrap tooltips
     */
    function initializeTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    /**
     * Initialize DataTables for table elements with .datatable class
     */
    function initializeDataTables() {
        const datatables = document.querySelectorAll('.datatable');
        
        if (datatables.length > 0 && typeof $.fn.DataTable !== 'undefined') {
            $('.datatable').DataTable({
                responsive: true,
                language: {
                    url: BASE_URL + 'assets/vendor/datatables/indonesian.json'
                }
            });
        }
    }
    
    /**
     * Initialize Select2 for select elements with .select2 class
     */
    function initializeSelect2() {
        const select2Elements = document.querySelectorAll('.select2');
        
        if (select2Elements.length > 0 && typeof $.fn.select2 !== 'undefined') {
            $('.select2').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        }
    }
    
    /**
     * Initialize sidebar toggle on mobile
     */
    function initializeSidebarToggle() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function() {
                document.querySelector('.app-container').classList.toggle('sidebar-collapsed');
            });
            
            // Close sidebar when clicking outside
            document.addEventListener('click', function(event) {
                const appContainer = document.querySelector('.app-container');
                const sidebar = document.querySelector('.sidebar');
                
                if (
                    appContainer && 
                    sidebar && 
                    appContainer.classList.contains('sidebar-collapsed') && 
                    !sidebar.contains(event.target) && 
                    !sidebarToggle.contains(event.target)
                ) {
                    appContainer.classList.remove('sidebar-collapsed');
                }
            });
        }
    }
    
    /**
     * Initialize password toggle for password fields
     */
    function initializePasswordToggle() {
        const toggleButtons = document.querySelectorAll('.toggle-password');
        
        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    }
    
    /**
     * Initialize auto-dismiss for alerts after 5 seconds
     */
    function initializeAlertAutoDismiss() {
        const alerts = document.querySelectorAll('.alert-dismissible');
        
        alerts.forEach(alert => {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    }
});

// Format date to readable format
function formatDate(dateString) {
    const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric'
    };
    
    return new Date(dateString).toLocaleDateString('id-ID', options);
}

// Format datetime to readable format
function formatDateTime(dateString) {
    const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    
    return new Date(dateString).toLocaleDateString('id-ID', options);
}

// Calculate time difference in readable format
function getTimeDiff(startDate, endDate = null) {
    const start = new Date(startDate);
    const end = endDate ? new Date(endDate) : new Date();
    
    const diffMs = end - start;
    const diffSec = Math.floor(diffMs / 1000);
    const diffMin = Math.floor(diffSec / 60);
    const diffHrs = Math.floor(diffMin / 60);
    const diffDays = Math.floor(diffHrs / 24);
    
    if (diffDays > 0) {
        return diffDays + (diffDays === 1 ? ' hari' : ' hari');
    } else if (diffHrs > 0) {
        return diffHrs + (diffHrs === 1 ? ' jam' : ' jam');
    } else if (diffMin > 0) {
        return diffMin + (diffMin === 1 ? ' menit' : ' menit');
    } else {
        return 'Baru saja';
    }
}