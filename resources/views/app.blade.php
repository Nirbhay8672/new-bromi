<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <link rel="icon" href="/favicon.png" type="image/png">
        <link rel="shortcut icon" href="/favicon.png" type="image/png">
        <link rel="apple-touch-icon" href="/favicon.png">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Font Awesome for social media icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <!-- Line Awesome Icons -->
        <link rel="stylesheet" href="/assets/vendor_assets/css/line-awesome.min.css">
        
        <!-- Feather Icons -->
        <script src="/assets/vendor_assets/js/feather.min.js"></script>
        
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="/assets/vendor_assets/css/bootstrap/bootstrap.css">
        
        <!-- jQuery UI CSS -->
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/ui-lightness/jquery-ui.css">
        
        <!-- Select2 CSS -->
        <link rel="stylesheet" href="/assets/vendor_assets/css/select2.min.css">
        
        <!-- Date Range Picker CSS -->
        <link rel="stylesheet" href="/assets/vendor_assets/css/daterangepicker.css">
        
        <!-- Theme CSS -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body>
        @inertia
        
        <!-- jQuery -->
        <script src="/assets/vendor_assets/js/jquery/jquery-3.5.1.min.js"></script>
        
        <!-- jQuery UI -->
        <script src="/assets/vendor_assets/js/jquery/jquery-ui.js"></script>
        
        <!-- Bootstrap JS -->
        <script src="/assets/vendor_assets/js/bootstrap/bootstrap.min.js"></script>
        
        <!-- Chart.js -->
        <script src="/assets/vendor_assets/js/Chart.min.js"></script>
        
        <!-- Other required JS -->
        <script src="/assets/vendor_assets/js/select2.full.min.js"></script>
        <script src="/assets/vendor_assets/js/daterangepicker.js"></script>
        <script src="/assets/vendor_assets/js/moment.min.js"></script>
        
        <!-- Main JS -->
        <script src="/assets/theme_assets/js/main.js"></script>
        
        <script>
            // Initialize Feather icons
            feather.replace();
            
            // Reinitialize icons after Vue components mount
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(() => {
                    if (typeof feather !== 'undefined') {
                        feather.replace();
                    }
                }, 100);
            });
        </script>
    </body>
</html>
