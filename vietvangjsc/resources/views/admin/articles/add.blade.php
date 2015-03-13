@extends('admin.layouts.layout')
@section('container')
 <div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    {!! $title !!}
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="{{ URL::to('admin') }}">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-edit"></i> {!! $title !!}
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-6">

                <form role="form">

                    <div class="form-group">
                        <label>Categories</label>
                        <select class="form-control">
                            <!-- for -->
                            <option>1</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Menu</label>
                        <select class="form-control">
                            <!-- for -->
                            <option>1</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Hit</label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="hit" id="hit" value="option1" checked>Yes
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="hit" id="hit" value="option2">No
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label>Text Input</label>
                        <input class="form-control">
                        <p class="help-block">Example block-level help text here.</p>
                    </div>

                    <div class="form-group">
                        <label>Text Input with Placeholder</label>
                        <input class="form-control" placeholder="Enter text">
                    </div>

                    <div class="form-group">
                        <label>Static Control</label>
                        <p class="form-control-static">email@example.com</p>
                    </div>

                    <div class="form-group">
                        <label>File input</label>
                        <input type="file" name="image">
                    </div>

                    

                    <div class="form-group">
                        <label>Inline Radio Buttons</label>
                        <label class="radio-inline">
                            <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline1" value="option1" checked>1
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline2" value="option2">2
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="optionsRadiosInline" id="optionsRadiosInline3" value="option3">3
                        </label>
                    </div>

                    

                    <div class="form-group">
                        <label>Multiple Selects</label>
                        <select multiple class="form-control">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-default">Submit Button</button>
                    <button type="reset" class="btn btn-default">Reset Button</button>

                </form>

            </div>
            <div class="col-lg-6">
                <h1>Disabled Form States</h1>

                <form role="form">

                    <fieldset disabled>

                        <div class="form-group">
                            <label for="disabledSelect">Disabled input</label>
                            <input class="form-control" id="disabledInput" type="text" placeholder="Disabled input" disabled>
                        </div>

                        <div class="form-group">
                            <label for="disabledSelect">Disabled select menu</label>
                            <select id="disabledSelect" class="form-control">
                                <option>Disabled select</option>
                            </select>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox">Disabled Checkbox
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary">Disabled Button</button>

                    </fieldset>

                </form>

                <h1>Form Validation</h1>

                <form role="form">

                    <div class="form-group has-success">
                        <label class="control-label" for="inputSuccess">Input with success</label>
                        <input type="text" class="form-control" id="inputSuccess">
                    </div>

                    <div class="form-group has-warning">
                        <label class="control-label" for="inputWarning">Input with warning</label>
                        <input type="text" class="form-control" id="inputWarning">
                    </div>

                    <div class="form-group has-error">
                        <label class="control-label" for="inputError">Input with error</label>
                        <input type="text" class="form-control" id="inputError">
                    </div>

                </form>

                <h1>Input Groups</h1>

                <form role="form">

                    <div class="form-group input-group">
                        <span class="input-group-addon">@</span>
                        <input type="text" class="form-control" placeholder="Username">
                    </div>

                    <div class="form-group input-group">
                        <input type="text" class="form-control">
                        <span class="input-group-addon">.00</span>
                    </div>

                    <div class="form-group input-group">
                        <span class="input-group-addon"><i class="fa fa-eur"></i></span>
                        <input type="text" class="form-control" placeholder="Font Awesome Icon">
                    </div>

                    <div class="form-group input-group">
                        <span class="input-group-addon">$</span>
                        <input type="text" class="form-control">
                        <span class="input-group-addon">.00</span>
                    </div>

                    <div class="form-group input-group">
                        <input type="text" class="form-control">
                        <span class="input-group-btn"><button class="btn btn-default" type="button"><i class="fa fa-search"></i></button></span>
                    </div>

                </form>

                <p>For complete documentation, please visit <a href="http://getbootstrap.com/css/#forms">Bootstrap's Form Documentation</a>.</p>

            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->
@endsection