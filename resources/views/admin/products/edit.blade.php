<x-main-layout>
    @section('title', 'Edit Product')

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card card-widget widget-user-2">
                    <div class="card-header">
                        <h3 class="card-title">Edit Product</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.products.update', $product->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group
                                @error('name') has-error @enderror">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}">
                                @error('name')
                                    <span class="help-block
                                        text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- descriptio --}}
                            <div class="form-group
                                @error('description') has-error @enderror">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control"
                                    rows="4">{{ $product->description }}</textarea>
                                @error('description')
                                    <span class="help-block
                                        text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group
                                @error('price') has-error @enderror">
                                <label for="price">Price</label>
                                <input type="number" name="price" id="price" class="form-control" value="{{ $product->price }}">
                                @error('price')
                                    <span class="help-block
                                        text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group
                                @error('stock') has-error @enderror">
                                <label for="stock">Stock</label>
                                <input type="number" name="stock" id="stock" class="form-control" value="{{ $product->stock }}">
                                @error('stock')
                                    <span class="help-block
                                        text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group
                                @error('image') has-error @enderror">
                                <label for="image">Image</label>
                                <input type="file" name="image" id="image" class="form-control" value="{{ $product->image }}">
                                @error('image')
                                    <span class="help-block
                                        text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-main-layout>
