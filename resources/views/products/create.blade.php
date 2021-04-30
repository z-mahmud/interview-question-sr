@extends('layouts.app')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create Product</h1>
    </div>
    <div id="app"></div>
    <div id="createProductApp">
        <div>
            <form class="row" @submit="createProduct">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" class="form-control" v-model="product.title">
                    </div>
                    <div class="form-group">
                        <label>Product SKU</label>
                        <input type="text" class="form-control" v-model="product.sku">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" cols="30" rows="10" v-model="product.description"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Product Image</label>
                        <input type="file" class="form-control" v-on:change="uploadProductImages">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Variants</label>
                        <div v-for="(vOption, index) in variantTotalOption">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" v-model="variantOptions[vOption-1]" placeholder="Option">
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" v-model="variantValues[vOption-1]" placeholder="Values">
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btn btn-primary" @click="addVariantOption">Add option</a>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-primary bg-gray-500 text-white">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        var app = new Vue({
            el: '#createProductApp',
            data: {
                product: {
                    title: '',
                    sku: '',
                    description: '',
                    files: [],
                },
                variantTotalOption: 1,
                variantOptions: [],
                variantValues: [],
            },
            mounted() {
                console.log('Component mounted');
            },
            methods: {
                createProduct(e) {
                    e.preventDefault();
                    console.log(this.variantOptions);

                    const config = {
                        headers: { 'content-type': 'multipart/form-data' }
                    }

                    axios.post('{{ route('product.store') }}', this.prepareFormData(this.product), config)
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

                    this.product.title = '';
                    this.product.sku = '';
                    this.product.description = '';
                    this.product.files = [];
                },

                uploadProductImages(e) {
                    // var files = e.target.files || e.dataTransfer.files;
                    // if (!files.length)
                    //     return;
                    // this.product.images = 'asdfsdfasd';
                    this.product.files = e.target.files[0] || e.dataTransfer.files[0];
                },

                prepareFormData(obj) {
                    var formData = new FormData();
                    for ( var key in obj ) {
                        formData.append(key, obj[key]);
                    }

                    return formData;
                },

                addVariantOption() {
                    this.variantTotalOption++;
                }
            }
        });
    </script>
@endpush
