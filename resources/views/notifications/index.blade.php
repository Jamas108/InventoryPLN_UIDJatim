@extends('layouts.app')

@section('content')
    @include('layouts.sidebar')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('layouts.navbar')

            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-1">
                    <h1 class="h3 mb-0 text-gray-800">Notifications ({{ $unreadNotificationsCount }} unread)</h1>
                </div>

                <div class="container-fluid pt-2 px-2">
                    <div class="card-body">
                        @if (empty($notifications) || count($notifications) == 0)
                            <h4 class="text-center mt-5">Tidak ada notifikasi</h4>
                        @else
                            <!-- Tombol untuk select all, mark as read all, dan delete all -->
                            <div class="d-flex mb-3">
                                <input type="checkbox" id="selectAll" class="mr-2"> Select All
                                <button id="markSelectedAsRead" class="btn btn-primary btn-sm ml-3 d-none">Mark as Read</button>
                                <button id="deleteSelected" class="btn btn-danger btn-sm ml-2 d-none">Delete</button>
                            </div>

                            <!-- Form untuk bulk action -->
                            <form id="bulkMarkAsReadForm" action="{{ route('notifications.bulkMarkAsRead') }}" method="POST">
                                @csrf
                                <input type="hidden" name="notification_ids" id="notificationIdsToMarkAsRead">
                            </form>

                            <form id="bulkDeleteForm" action="{{ route('notifications.bulkDelete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="notification_ids" id="notificationIdsToDelete">
                            </form>

                            @foreach ($notifications as $id => $notification)
                                @php
                                    $userId = auth()->user()->id;
                                    $roleId = auth()->user()->Id_Role;
                                    $roleKey = $roleId == 1 ? 'admin_' . $userId : 'user_' . $userId;
                                    $userStatus = $notification['user_status'][$roleKey]['status'] ?? 'unread';
                                @endphp

                                <div class="notification-item"
                                    style="background: {{ $userStatus == 'unread' ? '#fff' : '#f1f1f1' }}; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 10px; padding: 15px;">
                                    <div class="notification-header d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" class="notification-checkbox mr-2" value="{{ $id }}">
                                            <i class="fas fa-check-circle ml-2"
                                                style="font-size: 1.5rem; color: {{ $userStatus == 'unread' ? '#007bff' : '#5f5f5f' }};"></i>
                                            <h5 class="ml-3 mb-0">{{ $notification['title'] }}</h5>
                                        </div>
                                        <h8 class="ml-6 mb-0 text-muted">{{ $notification['created_at'] ?? 'N/A' }}</h8>
                                    </div>
                                    <div class="notification-body mt-3">
                                        <p>{{ $notification['message'] }}</p>
                                    </div>
                                    <div class="notification-footer d-flex justify-content-end mt-3">
                                        @if ($userStatus == 'unread')
                                            <form action="{{ route('notifications.markAsRead', $id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-primary">Mark as Read</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('notifications.destroy', $id) }}" method="POST" class="d-inline ml-2">
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
