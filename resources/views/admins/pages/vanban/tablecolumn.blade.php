<h1>{{ $title }}</h1>
<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên cột</th>
            <th>Kiểu dữ liệu</th>
            <th>Ghi chú</th>
            <th>Trạng thái yêu cầu</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($columnDataPaginated as $index => $column)
            <tr>
                <td>{{ $index + 1 + ($columnDataPaginated->currentPage() - 1) * $columnDataPaginated->perPage() }}
                </td>
                <td>{{ $column['name'] }}</td>
                <td>{{ $column['type'] }}</td>
                <td> {{  $comment[$column['name']] }}</td>
                <td>
                    <span class="badge {{ $column['is_required'] === 'Có' ? 'bg-danger' : 'bg-success' }}">
                        {{ $column['is_required'] === 'Có' ? 'Bắt buộc' : 'Không bắt buộc' }}
                    </span>
                </td>
                <td>
                    <form action="{{ route('admin.vanban.delete.column', $column['name']) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm css__column">
                            <img src="{{ asset('svg/delete.svg') }}" alt="SVG Image">
                        </button>
                        <a href="{{ route('admin.vanban.editColumn', ['column' => $column['name']]) }}"
                            class="btn btn-primary  main-action">
                            <img src="{{ asset('svg/edit.svg') }}" alt="SVG Image">
                        </a>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Phân trang -->
<div class="mt-3">
    {{ $columnDataPaginated->links() }}
</div>
