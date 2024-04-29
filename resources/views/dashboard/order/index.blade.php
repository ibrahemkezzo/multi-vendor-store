@extends('layouts.dashboards')

@section('title', 'Order')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">
        Order</li>
@endsection

@section('content')



    <x-form.alert type='success' />
    <x-form.alert type='info' />






    <table class="table">
        <thead>
            <tr>

                <th>NUMBER</th>
                <th>USER</th>
                <th>STORE</th>
                <th>STATUS</th>
                <th>TOTAL_PRICE</th>
                <th>DISCOUNT</th>
                <th>CREATED_AT</th>
                {{-- @dd(Auth::user()->can('create',Category::class)) --}}

                <th></th>
            </tr>
        </thead>
        <tbody>

            @forelse ($orders as $order)
                <tr>


                    <td> <a href="{{ route('dashboard.orders.show', $order->id) }}">{{ $order->number }}</a></td>
                    <td> {{ $order->user->name }} </td>
                    <td> {{ $order->store->name }} </td>
                    <td>{{ $order->status }}</td>{{-- {{$category->parent?$category->parent->name:'-'}} --}}
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->discount }}</td>
                    <td>{{ $order->created_at }}</td>
                    {{-- <td></td>
            <td></td> --}}

                    {{-- @dd(Auth::user()->hasAbility('category.update')) --}}
                    <td>
                        @can('update', $order)
                            <a href="{{ route('dashboard.orders.edit', $order->id) }}"class='btn btn-sm btn-outline-info'>edit</a>
                        @endcan
                    </td>
                    <td>



                        @if (Auth::user()->can('delete', $order))
                            <form action="{{ route('dashboard.orders.destroy', $order->id) }}" method="POST">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger">delete</button>
                            </form>
                        @endif
                    </td>


                @empty
                    <td colspan="8">there is not category</td>

                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $orders->withQueryString()->links() }}
@endsection
