<div class="collapse navbar-collapse navbar-ex1-collapse">
<ul class="nav navbar-nav side-nav">
    <li class="active">
        <a href="{{ URL::to('admin') }}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
    </li>
    <li>
        <a href="#"><i class="fa fa-fw fa-bar-chart-o"></i> Categories</a>
    </li>
    <li>
        <a href="javascript:;" data-toggle="collapse" data-target="#articles"><i class="fa fa-fw fa-arrows-v"></i> Articles <i class="fa fa-fw fa-caret-down"></i></a>
        <ul id="articles" class="collapse">
            <li>
                <a href="{{ URL::to('admin/articles') }}"><i class="fa fa-fw fa-table"></i> Articles</a>
            </li>
            <li>
                <a href="{{ URL::to('admin/articles/add') }}"><i class="fa fa-fw fa-edit"></i> Add Articles</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="javascript:;" data-toggle="collapse" data-target="#products"><i class="fa fa-fw fa-arrows-v"></i> Products <i class="fa fa-fw fa-caret-down"></i></a>
        <ul id="products" class="collapse">
            <li>
                <a href="#"><i class="fa fa-fw fa-table"></i> Products</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-fw fa-edit"></i> Add Products</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="javascript:;" data-toggle="collapse" data-target="#partners"><i class="fa fa-fw fa-arrows-v"></i> Partners <i class="fa fa-fw fa-caret-down"></i></a>
        <ul id="partners" class="collapse">
            <li>
                <a href="#"><i class="fa fa-fw fa-table"></i> Partners</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-fw fa-edit"></i> Add Partners</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="javascript:;" data-toggle="collapse" data-target="#users"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
        <ul id="users" class="collapse">
            <li>
                <a href="#"><i class="fa fa-fw fa-table"></i> Users</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-fw fa-edit"></i> Add Users</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="#"><i class="fa fa-fw fa-table"></i> Menus</a>
    </li>
    <li>
        <a href="#"><i class="fa fa-fw fa-edit"></i> Settings</a>
    </li>
</ul>
</div>