@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Bill</div>

                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" action="{{ route('update_bill', $bill->id) }}}">
                            @csrf

                            <div class="form-group row">
                                <label for="description"
                                       class="col-md-4 col-form-label text-md-right">Description</label>

                                <div class="col-md-6">
                                    <input id="description"
                                           type="text"
                                           class="form-control @error('description') is-invalid @enderror"
                                           name="description"
                                           value="{{ $bill->description }}"
                                           required
                                           autofocus>

                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="category" class="col-md-4 col-form-label text-md-right">Category</label>

                                <div class="col-md-6">
                                    <select id="category_id"
                                            type="text"
                                            class="form-control"
                                            name="category_id"
                                            required>
                                        @foreach ($categories as $category)
                                            <option @if($category->id === $bill->category->id) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="amount" class="col-md-4 col-form-label text-md-right">Amount</label>

                                <div class="col-md-6">
                                    <input id="amount"
                                           type="number"
                                           step="0.01"
                                           class="form-control @error('amount') is-invalid @enderror"
                                           name="amount"
                                           value="{{ $bill->amount }}"
                                           required>

                                    @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="photo" class="col-md-4 col-form-label text-md-right">Photo</label>

                                <div class="col-md-6" id="div_photo">
                                    @if( $bill->photo_name !== null)
                                        <a id="view_photo" target="_blank" href="{{ url( 'storage/bills/' . $bill->photo_name ) }}">
                                            <button type="button" class="btn btn-success">
                                                <i class="fas fa-file-image"></i>
                                            </button>
                                        </a>
                                    @endif
                                    <button id="upload_photo" class="btn btn-primary"><i class="fas fa-file-upload"></i></button>
                                    <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" hidden>
                                    @error('photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="{{ route('index_bill') }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#upload_photo').click(function(){
                $('#view_photo, #upload_photo').remove();
                $('#photo').removeAttr("hidden");
            });
        });
    </script>
@endsection
