@extends('layouts.app')
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')

            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-1">
                    <h1 class="h3 mb-0 text-gray-800">Notifications</h1>
                    <ul class="list-inline mb-0 mr-5 float-end">
                        <li class="list-inline-item">
                            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                    class="fas fa-bell"></i></a>
                        </li>
                    </ul>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="card-body">
                        @foreach ($notifications as $notification)
                            <div class="notification-item"
                                style="background: {{ $notification->status == 'unread' ? '#fff' : '#c3c3c3' }}; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px; padding: 15px;">
                                <div class="notification-header"
                                    style="display: flex; justify-content: space-between; align-items: center;">
                                    <div style="display: flex; align-items: center;">
                                        <i class="fas fa-check-circle"
                                            style="font-size: 1.5rem; margin-right: 10px; color: {{ $notification->status == 'unread' ? '#007bff' : '#5f5f5f' }};"></i>
                                        <h5 style="margin: 0; font-size: 1.25rem;">{{ $notification->title }}</h5>
                                    </div>
                                    <span class="date"
                                        style="font-size: 0.875rem; color: {{ $notification->status == 'unread' ? '#007bff' : '#6c757d' }};">{{ $notification->created_at->format('F d, Y') }}</span>
                                </div>
                                <div class="notification-body" style="margin-top: 10px;">
                                    <p>{{ $notification->message }}</p>
                                </div>
                                <div class="notification-footer"
                                    style="display: flex; justify-content: flex-end; margin-top: 15px;">
                                    <button class="btn btn-primary"
                                        onclick="location.href='{{ route('notifications.markAsRead', $notification->id) }}'">Mark
                                        as Read</button>
                                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger ml-2">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
