
$(document).ready(function() {
    $('#column-select').on('change', function() {
        var selectedColumns = $(this).val() || [];

        // Ẩn tất cả các cột trước khi hiển thị các cột đã chọn
        $('#userTable th, #userTable td').addClass('hidden');

        // Hiển thị các cột đã chọn
        selectedColumns.forEach(function(column) {
            $('#userTable .column-' + column).removeClass('hidden');
        });
    });
});

$(document).ready(function() {
    $('#exportExcelBtn').on('click', function() {
        $('<input type="file">').change(function() {
            var selectedFile = this.files[0];
            console.log('File đã chọn:', selectedFile);


            var formData = new FormData();
            formData.append('file', selectedFile);
            var url = "{{ route('import') }}";

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Kết quả:', response);

                },
                error: function(xhr, status, error) {
                    console.error('Đã xảy ra lỗi khi gửi file.');
                }
            });
        }).click();
    });
});
