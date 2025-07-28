@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="w-full h-screen grid grid-cols gap-5 px-4 lg:px-8 lg:grid-cols-2">
        <div class="max-h-fit col-span bg-slate-300 shadow-md rounded-lg p-4 lg:p-8 lg:col-span-1">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Profil Pengguna</h2>


            <div class="mb-4">
                <label class="block text-gray-600 font-medium mb-1">Nama</label>
                <p class="w-full px-4 py-2 border rounded-md bg-gray-100">{{ $user->name }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-600 font-medium mb-1">Email</label>
                <p class="w-full px-4 py-2 border rounded-md bg-gray-100">{{ $user->email }}</p>
            </div>
        </div>
    </div>
@endsection