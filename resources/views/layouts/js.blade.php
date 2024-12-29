<script src="{{asset('assets/plugins/common/common.min.js')}}"></script>
<script src="{{asset('assets/js/custom.min.js')}}"></script>
<script src="{{asset('assets/js/settings.js')}}"></script>
<script src="{{asset('assets/js/gleek.js')}}"></script>
<script src="{{asset('assets/js/styleSwitcher.js')}}"></script>

<!-- Chartjs -->
<script src="{{asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<!-- Circle progress -->
<script src="{{asset('assets/plugins/circle-progress/circle-progress.min.js')}}"></script>
<!-- Datamap -->
<script src="{{asset('assets/plugins/d3v3/index.js')}}"></script>
<script src="{{asset('assets/plugins/topojson/topojson.min.js')}}"></script>
{{-- <script src="{{asset('assets/plugins/datamaps/datamaps.world.min.js')}}"></script> --}}
<!-- Morrisjs -->
<script src="{{asset('assets/plugins/raphael/raphael.min.js')}}"></script>
<script src="{{asset('assets/plugins/morris/morris.min.js')}}"></script>
<!-- Pignose Calender -->
<script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/plugins/pg-calendar/js/pignose.calendar.min.js')}}"></script>
<!-- ChartistJS -->
<script src="{{asset('assets/plugins/chartist/js/chartist.min.js')}}"></script>
<script src="{{asset('assets/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js')}}"></script>
<script src="{{asset('assets/js/dashboard/dashboard-1.js')}}"></script>
<script src="{{asset('assets/plugins/tables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/tables/js/datatable-init/datatable-basic.min.js')}}"></script>
<script src="{{asset('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}">
</script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- <script src="{{asset('assets/js/plugins-init/form-pickers-init.js')}}"></script> --}}
{{-- <script src="./js/dashboard/dashboard-1.js"></script> --}}
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>
    // Fungsi untuk menyaring data berdasarkan input pencarian
    function filterTable(searchValue) {
        let tables = document.querySelectorAll('table'); // Ambil semua tabel
        let noDataFound = true; // Flag untuk cek apakah data ditemukan

        tables.forEach(function(table) {
            let tableRows = table.getElementsByTagName('tr'); // Ambil semua row tabel
            let noDataRow = document.getElementById('noDataRow'); // Ambil row pesan tidak ada data

            Array.from(tableRows).forEach(function(row, index) {
                if (index === 0) return; // Lewati baris header

                let cells = row.getElementsByTagName('td');
                let rowMatch = false;

                // Loop untuk mengecek setiap cell dalam row
                Array.from(cells).forEach(function(cell) {
                    // Case-insensitive matching dengan pencarian berbasis kata
                    if (cell.textContent.toLowerCase().includes(searchValue)) {
                        rowMatch = true;
                    }
                });

                // Menampilkan atau menyembunyikan row sesuai pencocokan
                row.style.display = rowMatch ? '' : 'none';

                // Jika ada row yang cocok, set noDataFound ke false
                if (rowMatch) {
                    noDataFound = false;
                }
            });

            // Menampilkan atau menyembunyikan row pesan tidak ditemukan
            if (noDataFound) {
                if (!noDataRow) {
                    // Jika row tidak ada, tambahkan row baru untuk pesan
                    let noDataRow = document.createElement('tr');
                    noDataRow.id = 'noDataRow';
                    let cell = document.createElement('td');
                    cell.colSpan = tableRows[0].cells.length; // Set agar pesan melintang di semua kolom
                    cell.style.textAlign = 'center';
                    cell.style.color = 'red';
                    cell.textContent = 'Data tidak ditemukan.';
                    noDataRow.appendChild(cell);
                    table.querySelector('tbody').appendChild(noDataRow);
                }
            } else {
                // Jika data ditemukan, sembunyikan row pesan
                if (noDataRow) {
                    noDataRow.style.display = 'none';
                }
            }
        });
    }

    // Event listener untuk tombol search
    document.getElementById('globalSearchButton').addEventListener('click', function() {
        let searchValue = document.getElementById('globalSearchInput').value.trim().toLowerCase(); // Ambil nilai dari input
        filterTable(searchValue); // Panggil fungsi filter untuk menyaring data
    });

    // Event listener untuk input form, jika kosong tampilkan semua data
    document.getElementById('globalSearchInput').addEventListener('input', function() {
        let searchValue = this.value.trim().toLowerCase(); // Ambil nilai dari input

        if (searchValue === "") {
            // Jika input kosong, tampilkan semua baris
            filterTable("");
        } else {
            filterTable(searchValue); // Panggil fungsi filter untuk menyaring data
        }
    });
</script>




<script>
    $(document).ready(function() {
        $('#categoryTable').DataTable();

        // Edit Button Click
        $('.edit-btn').on('click', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');

            // Set form action dynamically
            $('#editCategoryForm').attr('action', `{{ url('edit_category') }}/${id}`);
            $('#editCategoryName').val(name);

            // Show the modal
            $('#editCategoryModal').modal('show');
        });

        // Delete Confirmation
        $('.delete-btn').on('click', function() {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-form-' + id).submit();
                }
            });
        });
    });
</script>

<script>
  window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
      });
  }, 4000);
</script>
<script>
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @elseif(session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>

<script>
    // Event handler untuk tombol Import
    document.getElementById('importButton').addEventListener('click', function () {
        document.getElementById('excelInput').click(); // Membuka dialog pemilihan file
    });

    // Event handler untuk input file
    document.getElementById('excelInput').addEventListener('change', function () {
        if (this.files.length > 0) {
            // Jika ada file yang dipilih, submit form
            document.getElementById('importForm').submit();
        }
    });
</script>
<!-- Date Range Picker JS -->
<script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(document).ready(function () {
        $('#date_range').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            autoUpdateInput: false,
            opens: 'left',
        });

        // Update input field on apply
        $('#date_range').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });

        // Clear input field on cancel
        $('#date_range').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    });
</script>



{{-- <script>
  $(document).ready(function() {
      // Initialize Select2
      $('#vendor_name').select2({
          placeholder: "Select Vendor *",
          allowClear: false
      });
  });
</script> --}}
