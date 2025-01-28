@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Product Information
                </div>
                <div class="float-end">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                    <div class="roww">
                        <div>
                            <label for="name" class=""><strong>Name:</strong></label>
                        </div>
                        <div ">
                            {{ $product->name }}
                        </div>
                    </div>
                    <div class="roww">
                        <div>
                            <label for="description" class=""><strong>Description:</strong></label>
                        </div>
                        <div ">
                            {{ $product->description }}
                        </div>
                    </div>
        
            </div>
        </div>
    </div>    
</div>

<style>
    .roww {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    label {
        font-size: 15px;
        display: block;
    }
</style>
    
@endsection