<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- <title>{{ config('app.name') }}</title> --}}
        <title>Portal do Cliente</title>

        <!-- favicon -->
        <link rel="icon" type="image/x-icon" href="http://portaldocliente.las.app.br/storage/images/Logo_favicon_LAS.png">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
         <!-- Sweet Alert-->
        <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
        
        

        

        <!-- jquery mask -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

        
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/todo.js') }}" defer></script>
    </head>
    <body data-sidebar="dark" >
        
        <div id="layout-wrapper">
            @include('layouts.navigation')
            <main>
                <div class="main-content">
                    <div class="page-content">
                        <div class="container-fluid">
                            {{ $slot }}
                        </div>
                    </div>
                    <footer class="footer">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-6">
                                    <script>document.write(new Date().getFullYear())</script> © LAS.
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-sm-end d-none d-sm-block">
                                        Portal do Cliente
                                    </div>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </main>
            
        </div>

        <!-- Scripts -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

        <!-- Sweet Alerts js -->
        <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

        <script src="{{ asset('assets/js/app.js') }}"></script>
    </body>
</html>
