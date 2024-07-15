@extends('layouts.app')
@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')

            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-1">

                    <ul class="list-inline mb-0 mr-5 float-end">
                        <li class="list-inline-item">
                            <input type="checkbox" id="selectAll">
                            <label for="selectAll">Select All</label>
                        </li>
                        <li class="list-inline-item">
                            <form action="{{ route('notifications.bulkMarkAsRead') }}" method="POST" id="bulkMarkAsReadForm">
                                @csrf
                                <input type="hidden" name="notification_ids" id="notificationIdsToMarkAsRead">
                                <button type="button" class="d-none btn btn-sm btn-primary shadow-sm" id="markSelectedAsRead"><i class="fas fa-envelope-open"></i> Mark Selected as Read</button>
                            </form>
                        </li>
                        <li class="list-inline-item">
                            <form action="{{ route('notifications.bulkDelete') }}" method="POST" id="bulkDeleteForm">
                                @csrf
                                <input type="hidden" name="notification_ids" id="notificationIdsToDelete">
                                <button type="button" class="d-none btn btn-sm btn-danger shadow-sm" id="deleteSelected"><i class="fas fa-trash-alt"></i> Delete Selected</button>
                            </form>
                        </li>
                    </ul>
                    <h1 class="h3 mb-0 text-gray-800">Notifications</h1>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="card-body">
                        @if ($notifications->isEmpty())
                            <h4 class="text-center mt-5">Tidak ada notifikasi</h4>
                        @else
                            @foreach ($notifications as $notification)
                                <div class="notification-item"
                                    style="background: {{ $notification->status == 'unread' ? '#fff' : '#f1f1f1' }}; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px; padding: 15px;">
                                    <div class="notification-header d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="notification-checkbox" value="{{ $notification->id }}">
                                            <i class="fas fa-check-circle ml-2" style="font-size: 1.5rem; color: {{ $notification->status == 'unread' ? '#007bff' : '#5f5f5f' }};"></i>
                                            <h5 class="ml-3 mb-0">{{ $notification->title }}</h5>
                                        </div>
                                        <span class="date" style="font-size: 0.875rem; color: {{ $notification->status == 'unread' ? '#007bff' : '#6c757d' }};">{{ $notification->created_at->format('F d, Y') }}</span>
                                    </div>
                                    <div class="notification-body mt-3">
                                        <p>{{ $notification->message }}</p>
                                    </div>
                                    <div class="notification-footer d-flex justify-content-end mt-3">
                                        @if($notification->status == 'unread')
                                            <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">Mark as Read</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="d-inline ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('selectAll').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('.notification-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
            toggleBulkActions();
        });

        document.querySelectorAll('.notification-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                toggleBulkActions();
            });
        });

        function toggleBulkActions() {
            var anyChecked = document.querySelectorAll('.notification-checkbox:checked').length > 0;
            document.getElementById('markSelectedAsRead').classList.toggle('d-none', !anyChecked);
            document.getElementById('deleteSelected').classList.toggle('d-none', !anyChecked);
        }

        document.getElementById('markSelectedAsRead').addEventListener('click', function() {
            var selected = Array.from(document.querySelectorAll('.notification-checkbox:checked')).map(checkbox => checkbox.value);
            document.getElementById('notificationIdsToMarkAsRead').value = selected.join(',');
            document.getElementById('bulkMarkAsReadForm').submit();
        });

        document.getElementById('deleteSelected').addEventListener('click', function() {
            var selected = Array.from(document.querySelectorAll('.notification-checkbox:checked')).map(checkbox => checkbox.value);
            document.getElementById('notificationIdsToDelete').value = selected.join(',');
            document.getElementById('bulkDeleteForm').submit();
        });
    </script>
@endsection
