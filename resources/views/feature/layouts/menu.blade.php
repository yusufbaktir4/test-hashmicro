<!-- start: sidebar -->
<aside id="sidebar-left" class="sidebar-left">

    <div class="sidebar-header">
        <div class="sidebar-title">
            Navigation
        </div>
        <div class="sidebar-toggle d-none d-md-block" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">

                <?php 
                    $menuItems = [
                        ['label' => 'Dashboard', 'url' => [route('home')]]
                    ];

                    $items = [
                        ['label' => 'Cek 2 Free Input', 'url' => 'cek_input_user'],
                        ['label' => 'Project', 'url' => 'feature.project.index'],
                    ];

                    if(count($items) > 0){
                        $menuItems[] = ['label' => 'Feature', 'items' => $items];
                    }
                ?>

                <ul class="nav nav-main">
                    <?php foreach ($menuItems as $key => $value): ?>
                            <?php if (!isset($value['items'])): ?>
                                <li>
                                    <a class="nav-link" href="{{route('home')}}">
                                        <i class="bx bx-home-alt" aria-hidden="true"></i>
                                        <span>Dashboard</span>
                                    </a>                        
                                </li>
                            <?php else: ?>
                                <li class="nav-parent">
                                    <a class="nav-link" href="#">
                                        <i class="bx bx-cube-alt" aria-hidden="true"></i>
                                        <span>{{$value['label']}}</span>
                                    </a>

                                    <?php foreach ($value['items'] as $keyItems => $valueItems): ?>
                                        <ul class="nav nav-children">
                                            <li>
                                                <a class="nav-link" href="{{route($valueItems['url'])}}">
                                                    {{$valueItems['label']}}
                                                </a>
                                            </li>
                                        </ul>
                                    <?php endforeach ?>
                                </li>
                            <?php endif ?>
                    <?php endforeach ?>
                </ul>
            </nav>
        </div>

        <script>
            // Maintain Scroll Position
            if (typeof localStorage !== 'undefined') {
                if (localStorage.getItem('sidebar-left-position') !== null) {
                    var initialPosition = localStorage.getItem('sidebar-left-position'),
                        sidebarLeft = document.querySelector('#sidebar-left .nano-content');

                    sidebarLeft.scrollTop = initialPosition;
                }
            }
        </script>

    </div>

</aside>
<!-- end: sidebar