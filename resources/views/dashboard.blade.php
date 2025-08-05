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
                
                <article class="dash-main">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                        Corporis reiciendis maiores optio sint provident nemo nihil 
                        dolorum? Ipsa eius quasi ipsam, beatae ea, consequatur, in eaque vero 
                        sapiente delectus reiciendis.
                    </p>
                </article>
                <aside class="aside aside1">
                    <h1>Aside1</h1>
                </aside>
                <aside class="aside aside2">
                    <h1>Aside2</h1>
                </aside>
                <footer class="footer">
                    <h1>Footer</h1>
                </footer>
            </div>
        </div>
        
    </body>
</html>