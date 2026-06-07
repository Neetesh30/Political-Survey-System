@extends('layouts.admin.master')
@section('content')
<div class="page-wrapper">
			
    <div class="content container-fluid">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                     @error('image')
                    <div class="alert alert-warning">
                        {{$message}}
                    </div>
                @enderror
                @if (Session::get('fail'))
                    <div class="alert alert-danger">
                        {!! Session::get('fail')  !!}
                    </div>
                @endif
                @if (Session::get('danger'))
                    <div class="alert alert-danger">
                        {!! Session::get('danger')  !!}
                    </div>
                @endif
                @if (Session::get('success'))
                    <div class="alert alert-success">
                        {!! Session::get('success')  !!}
                    </div>
                @endif

                @foreach ($errors->all() as $message)
                    <div class="alert alert-danger">
                            {{$message}}
                        </div>
                @endforeach

                    <h3 class="page-title">Welcome  Admin !</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">{{auth()->user()->name}} | Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header" id="ajaxalertcontainer">
                        <h4 class="card-title">Schedule Daily Quiz Interaction</h4>
                    </div>
                    <div class="card-body">
                       
                        @if ($dailyquizdata->isNotEmpty())
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group row">
                                        <label class="col-lg-6 col-form-label">Select Type </label>
                                        <div class="col-lg-6">
                                                <select class="form-control" name="" id="selectquiztype">
                                                    <option>{{ $dailyquizdata->isNotEmpty() ? $dailyquizdata->first()->quiz_type : '' }}</option>
                                                    <option>-- Select Type --</option>
                                                    <option value="mcq">Mcq</option>
                                                    <option value="truefalse">True False</option>
                                                    <option value="statement">Statement</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                        @endif

                        @if ($dailyquizdata->isNotEmpty())
                                <?php
                                    $style = '';
                                    if ($dailyquizdata->isNotEmpty()) {
                                        $style = $dailyquizdata->first()->quiz_type == 'mcq' ? 'yes' : 'display:none;';
                                    }
                                ?>
                                <form action="{{ route('admin.update-dailyquiz', $dailyquizdata->first()->id) }}" class="mcq_section_form"  style="{{ $style }}"   method="post">
                                    @csrf
                                    @if ($dailyquizdata->isNotEmpty())
                                        @method('PUT')
                                    @endif
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label">Question </label>
                                                <input type="hidden" name="quiz_type" value="mcq">
                                                <div class="col-lg-6">
                                                    @if ($dailyquizdata->first()->quiz_type == 'mcq')
                                                        <input type="text" name="question" value="{{ $dailyquizdata->isNotEmpty() ? $dailyquizdata->first()->question : '' }}" class="form-control" required>
                                                    @else
                                                        <input type="text" name="question"  class="form-control" required>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label">Option 1</label>
                                                <div class="col-lg-6">
                                                    @if ($dailyquizdata->first()->quiz_type == 'mcq')
                                                        <input type="text" name="option1" value="{{ $dailyquizdata->isNotEmpty() ? $dailyquizdata->first()->option1 : '' }}" class="form-control" required>
                                                    @else
                                                        <input type="text" name="option1"  class="form-control" required>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label">Option 2</label>
                                                <div class="col-lg-6">
                                                    @if ($dailyquizdata->first()->quiz_type == 'mcq')
                                                        <input type="text" name="option2" value="{{ $dailyquizdata->isNotEmpty() ? $dailyquizdata->first()->option2 : '' }}" class="form-control" required>
                                                    @else
                                                        <input type="text" name="option2"  class="form-control" required>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label">Option 3</label>
                                                <div class="col-lg-6">
                                                    @if ($dailyquizdata->first()->quiz_type == 'mcq')
                                                    <input type="text" name="option3" value="{{ $dailyquizdata->isNotEmpty() ? $dailyquizdata->first()->option3 : '' }}" class="form-control" required>
                                                    @else
                                                    <input type="text" name="option3"  class="form-control" required>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label">Option 4</label>
                                                <div class="col-lg-6">
                                                    @if ($dailyquizdata->first()->quiz_type == 'mcq')
                                                        <input type="text" name="option4" value="{{ $dailyquizdata->isNotEmpty() ? $dailyquizdata->first()->option4 : '' }}" class="form-control" required>
                                                    @else
                                                        <input type="text" name="option4"  class="form-control" required>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label">Correct Answer</label>
                                                <div class="col-lg-6">
                                                    @if ($dailyquizdata->first()->quiz_type == 'mcq')
                                                            <input type="text" name="correct_option" value="{{ $dailyquizdata->isNotEmpty() ? $dailyquizdata->first()->correct_option : '' }}" class="form-control" required>
                                                    @else
                                                            <input type="text" name="correct_option" class="form-control" required>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label">Correct Answer Explanation</label>
                                                <div class="col-lg-6">
                                                    @if ($dailyquizdata->first()->quiz_type == 'mcq')
                                                        <textarea name="explanation" class="form-control" id="" cols="30" rows="5" required>{{ $dailyquizdata->isNotEmpty() ? $dailyquizdata->first()->explanation : '' }}</textarea>
                                                    @else
                                                        <textarea name="explanation" class="form-control" id="" cols="30" rows="5" required></textarea>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="text-left">
                                        <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                        @endif

                        @if ($dailyquizdata->isNotEmpty())
                            <?php
                                $style = '';
                                if ($dailyquizdata->isNotEmpty()) {
                                    $style = $dailyquizdata->first()->quiz_type == 'truefalse' ? 'yes' : 'display:none;';
                                } 
                            ?>    
                            <form action="{{ route('admin.update-dailyquiz', $dailyquizdata->first()->id) }}" class="truefalse_section_form" style="{{ $style }}" method="post">
                                    @csrf
                                    @if ($dailyquizdata->isNotEmpty())
                                        @method('PUT')
                                    @endif
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label">Question </label>
                                                <input type="hidden" name="quiz_type" value="truefalse">
                                                <div class="col-lg-6">
                                                    @if ($dailyquizdata->first()->quiz_type == 'truefalse')
                                                        <input type="text" name="question" value="{{ $dailyquizdata->isNotEmpty() ? $dailyquizdata->first()->question : '' }}" class="form-control" required>
                                                    @else
                                                        <input type="text" name="question"  class="form-control" required>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label">True</label>
                                                <div class="col-lg-6">
                                                    <input type="text" name="option1" value="True" readonly class="form-control" required>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label">False</label>
                                                <div class="col-lg-6">
                                                    <input type="text" name="option2" value="False" readonly class="form-control" required>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label">Correct Answer</label>
                                                <div class="col-lg-6">
                                                    @if ($dailyquizdata->first()->quiz_type == 'truefalse')
                                                        <input type="text" name="correct_option" value="{{ $dailyquizdata->isNotEmpty() ? $dailyquizdata->first()->correct_option : '' }}" class="form-control" required>
                                                    @else
                                                        <input type="text" name="correct_option"  class="form-control" required>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label">Correct Answer Explanation</label>
                                                <div class="col-lg-6">
                                                    @if ($dailyquizdata->first()->quiz_type == 'truefalse')
                                                        <textarea name="explanation" class="form-control" id="" cols="30" rows="5" required>{{ $dailyquizdata->isNotEmpty() ? $dailyquizdata->first()->explanation : '' }}</textarea>
                                                    @else
                                                        <textarea name="explanation" class="form-control" id="" cols="30" rows="5" required></textarea>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="text-left">
                                        <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                        @endif
                        
                        @if ($dailyquizdata->isNotEmpty())
                               <?php
                                    $style = '';
                                    if ($dailyquizdata->isNotEmpty()) {
                                        $style = $dailyquizdata->first()->quiz_type == 'statement' ? 'yes' : 'display:none;';
                                    } 
                                ?>    
                                <form action="{{ route('admin.update-dailyquiz', $dailyquizdata->first()->id) }}" class="statement_section_form" style="{{ $style }}"  method="post">
                                    @csrf
                                    @if ($dailyquizdata->isNotEmpty())
                                        @method('PUT')
                                    @endif
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label">Statement </label>
                                                <input type="hidden" name="quiz_type" value="statement">
                                                <div class="col-lg-6">
                                                    @if ($dailyquizdata->first()->quiz_type == 'statement')
                                                        <textarea name="question" class="form-control" id="" cols="30" rows="5" required>{{ $dailyquizdata->isNotEmpty() ? $dailyquizdata->first()->question : '' }}</textarea>
                                                        @else
                                                        <textarea name="question" class="form-control" id="" cols="30" rows="5" required></textarea>
                                                    @endif
                                                    
                                                </div>
                                            </div>
                                        </div>    
                                    </div>
                                
                                    <div class="text-left">
                                        <button type="submit" id="submitButton" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>
    </div>			
</div>
<!-- /Page Wrapper -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#selectquiztype').change(function() {
            var selectedType = $(this).val();
            $('.mcq_section_form').hide();
            $('.truefalse_section_form').hide();
            $('.statement_section_form').hide();
            
            if (selectedType == 'mcq') {
                $('.mcq_section_form').show();
            } else if (selectedType == 'truefalse') {
                $('.truefalse_section_form').show();
            } else if (selectedType == 'statement') {
                $('.statement_section_form').show();
            }
        });
        
        // Trigger change event to handle pre-selected option
        $('#selectquiztype').trigger('change');
    });
</script>
@endsection
