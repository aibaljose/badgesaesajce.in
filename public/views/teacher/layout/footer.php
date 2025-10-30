    
        <footer class="footer mt-auto py-3">
            <div class="container">
                <div class="text-center">
                    © <?php echo date('Y'); ?> Academic Enterprise Solutions (AES)
                </div>
            </div>
        </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Sidebar toggle (works with the toggle button added to header if present)
        (function(){
            var btn = document.getElementById('sidebarToggle');
            var sidebar = document.querySelector('.sidebar');
            if (btn && sidebar) {
                btn.addEventListener('click', function(e){
                    e.preventDefault();
                    sidebar.classList.toggle('open');
                    document.body.classList.toggle('sidebar-open');
                });
            }

            // Trigger Chart.js resize if necessary on orientation/resize for compact layouts
            var resizeTimeout;
            function triggerChartResize(){
                if (typeof Chart !== 'undefined' && Chart.instances) {
                    Object.values(Chart.instances).forEach(function(chart){ try{ chart.resize(); }catch(e){} });
                }
            }
            window.addEventListener('resize', function(){
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(triggerChartResize, 160);
            });
        })();
    </script>
</body>
</html>
