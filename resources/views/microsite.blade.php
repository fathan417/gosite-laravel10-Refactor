<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

 @include('partials.dash-head')
 
    <body class="container">
        @include('partials.sidebar')
        <div class="main-content">
            <header class="dash-header">
                @include('partials.buttons')
                <h1>{{ $sidebar }}</h1>
            </header>
            <div class="wrapper">
                
                <div class="dash-main">
                    <h1>My Microsites</h1>
                    <div class="content-list">
                        <div class="icon">

                        </div>
                        <div class="item-list">
                            
                        </div>
                    </div>
                    <div class="content-list">
                        pilihan 2
                    </div>
                    <div class="content-list">
                        pilihan 3
                    </div>
                </div>
                <!-- <aside class="aside aside1">
                    <h1>Aside1</h1>
                </aside> -->
                <aside class="aside aside2">
                    <!-- <h1>Aside2</h1> -->
                </aside>
                <footer class="footer">
                    <h1>Footer</h1>
                </footer>
            </div>
        </div>
        
    </body>
</html>