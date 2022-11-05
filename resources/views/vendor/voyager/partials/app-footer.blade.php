<footer class="app-footer" style="background: #bbc77c; color: #394916; position: fixed;box-shadow: 0 0 15px rgb(0 0 0 / 20%);bottom: 0px;opacity: 1;z-index: 10;">
    <div class="site-footer-right">
        @if (rand(1,100) == 100)
            <i class="voyager-rum-1"></i> {{ __('voyager::theme.footer_copyright2') }}
        @else
            <b><a style="color:#394916;" href="https://soporte.inggen.com" target="_blank">Soporte <i class="icon voyager-rocket" style="color: #394916;"></i></a></b>
            &nbsp;&nbsp; | &nbsp;&nbsp;
            Hecho con <i class="icon voyager-heart"  style="color: #394916;"></i> por <b><a style="color:#394916;" href="https://inggen.com" target="_blank">Inggen.com</a></b>
        @endif
    </div>
</footer>
