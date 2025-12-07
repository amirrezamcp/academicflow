@extends('layouts.app')

@section('title', 'ویرایش استاد')

@section('content')
<h2 class="text-2xl font-bold mb-4">ویرایش استاد</h2>

<form method="POST" action="{{ route('masters.update', $master) }}" class="bg-white p-6 rounded-xl shadow card-hover max-w-2xl">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block mb-1 font-medium">نام</label>
        <input type="text" name="name" value="{{ old('name', $master->name) }}" class="input-focus border rounded-lg w-full p-2" >
        @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-medium">مدرک</label>
        <input type="text" name="graduation" value="{{ old('graduation', $master->graduation) }}" class="input-focus border rounded-lg w-full p-2">
        @error('graduation') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex gap-3">
        <a href="{{ route('masters.index') }}" class="px-4 py-2 rounded-lg border">انصراف</a>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg button-press">ذخیره تغییرات</button>
    </div>
</form>
@endsection
