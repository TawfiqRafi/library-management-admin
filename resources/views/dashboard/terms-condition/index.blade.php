@extends('layouts.dashboard')

@section('content')

    <div class="box">
        <div class="box-header with-action">
            <h5 class="box-title">Terms & Condition Page</h5>
        </div>
        {!! Form::open(['route' => ['terms-condition.store'], 'method' => 'POST']) !!}
        <div class="box-body">
            <div class="form-group" style="margin-bottom:0%;">
            </div>
            {{-- <div class="form-group row">
                <label for="" class="col-md-3 col-form-label"></label>
                <div class="col-md-9">
                    <center>
                        <img style="width: 20%;border: 1px solid; border-radius: 10px;" id="viewer" src="{{asset($data['image'])}}" onerror="this.src='{{ asset('assets/frontend/img/img2.jpg')}}'" alt="privacy image"/>
                    </center>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="col-md-3 col-form-label">Image</label>
                <div class="col-md-9">
                    <div class="custom-file">
                        <input type="file" name="image" id="customFileEg1" class="custom-file-input"
                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                        <label class="custom-file-label" for="customFileEg1">Choose Image</label>
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                </div>
            </div> --}}
            <div class="form-group row">
                <label for="" class="col-md-3 col-form-label">Content</label>
                <div class="col-md-9">
                    {{-- <textarea type="text" name="content" id="" placeholder="Enter content" class="form-control description_summernote">{{$data->content}}</textarea> --}}
                    <textarea class="ckeditor form-control" name="content">{!! $data['content'] !!}</textarea>
                    <span class="text-danger">{{ $errors->first('content') }}</span>
                </div>
            </div>

            <div class="form-group my-10 text-right">
                <button type="submit" class="btn btn-primary" onclick="formSubmit(this, event)">Save</button>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="box-footer">

        </div>
    </div>


@endsection
@push('footer-scripts')
<script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.ckeditor').ckeditor();
    });
</script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#viewer').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#customFileEg1").change(function () {
        readURL(this);
    });
 </script>

@endpush
