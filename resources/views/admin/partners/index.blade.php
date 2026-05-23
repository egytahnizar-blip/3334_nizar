@extends('layouts.admin', ['title' => 'Kelola Partner'])

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Kelola Partner
</h1>

@if(session('success'))
    <div class="mb-5 p-4 bg-green-100 text-green-700 rounded-xl">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white p-6 rounded-3xl shadow-sm">

    {{-- SEARCH --}}
    <form method="GET" class="flex gap-3 mb-6">

        <input
            type="text"
            name="search"
            placeholder="Cari partner..."
            value="{{ request('search') }}"
            class="border rounded-xl px-4 py-2"
        >

        <button
            type="submit"
            class="bg-slate-900 text-white px-5 py-2 rounded-xl"
        >
            Cari
        </button>

    </form>

    {{-- TAMBAH --}}
    <form
        action="{{ route('admin.partners.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="flex gap-3 mb-6"
    >

        @csrf

        <input
            type="text"
            name="name"
            placeholder="Nama partner"
            class="border rounded-xl px-4 py-2"
        >

        <input
            type="file"
            name="logo_url"
            class="border rounded-xl px-4 py-2"
        >

        <button
            type="submit"
            class="bg-indigo-600 text-white px-5 py-2 rounded-xl"
        >
            Tambah
        </button>

    </form>

    {{-- TABLE --}}
    <table class="w-full">

        <tr class="border-b">
            <th class="py-3 text-left">ID</th>
            <th class="py-3 text-left">Logo</th>
            <th class="py-3 text-left">Nama</th>
            <th class="py-3 text-left">Aksi</th>
        </tr>

        @foreach($partners as $partner)

        <tr class="border-b">

            <td class="py-3">
                {{ $partner->id }}
            </td>

            <td class="py-3">

                <img
                    src="{{ asset('storage/' . $partner->logo_url) }}"
                    class="w-16 h-16 object-cover rounded-xl"
                >

            </td>

            <td class="py-3">
                {{ $partner->name }}
            </td>

            <td class="py-3 flex gap-2">

                {{-- EDIT --}}
                <form
                    action="{{ route('admin.partners.update', $partner->id) }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="flex gap-2"
                >

                    @csrf
                    @method('PUT')

                    <input
                        type="text"
                        name="name"
                        value="{{ $partner->name }}"
                        class="border rounded-xl px-3 py-1"
                    >

                    <input
                        type="file"
                        name="logo_url"
                        class="border rounded-xl px-3 py-1"
                    >

                    <button
                        type="submit"
                        class="bg-indigo-500 text-white px-3 py-1 rounded-xl"
                    >
                        Edit
                    </button>

                </form>

                {{-- DELETE --}}
                <form
                    action="{{ route('admin.partners.destroy', $partner->id) }}"
                    method="POST"
                >

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="bg-red-500 text-white px-3 py-1 rounded-xl"
                    >
                        Delete
                    </button>

                </form>

            </td>

        </tr>

        @endforeach

    </table>

</div>

@endsection
