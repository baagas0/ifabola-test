<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')
    <p><a href="{{ g('return_url', '/admin/sales_orders') }}"><i class="fa fa-chevron-circle-left"></i>
            &nbsp; Back To Transaksi Sales Order</a></p>
    <div class="box box-default">
        <div class="box-body table-responsive no-padding">
            <table class="table table-bordered">
                <tbody>
                    <tr class="active">
                        <td colspan="2"><strong><i class="fa fa-bars"></i> Detail</strong></td>
                    </tr>
                    <tr>
                        <td width="25%"><strong>
                                Company
                            </strong></td>
                        <td>{{ $parent->company()->name }}</td>
                    </tr>
                    <tr>
                        <td width="25%"><strong>
                                Tanggal
                            </strong></td>
                        <td> {{ date('d F Y', strtotime($parent->date)) }}</td>
                    </tr>
                    <tr>
                        <td width="25%"><strong>
                                Total
                            </strong></td>
                        <td> {{ number_format($parent->total, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="box">
        <div class="box-body table-responsive no-padding">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Daftar Barang</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        @php
                            $grand_total = 0;
                            $discount = 0;
                            $total = 0;
                        @endphp
                        <table id="table_dashboard" class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr class="active">
                                    <th width="auto">Created at</th>
                                    <th width="auto">Nama Barang</th>
                                    <th width="auto">Harga</th>
                                    <th width="auto">Jumlah</th>
                                    <th width="auto">Total</th>
                                    <th width="auto">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($results as $row)
                                    <tr>
                                        <td>{{ $row->created_at }}</td>
                                        <td>{{ $row->goods_name }}</td>
                                        <td>{{ number_format($row->goods_price, 0, ',', '.') }}</td>
                                        <td>{{ number_format($row->qty, 0, ',', '.') }}</td>
                                        <td>{{ number_format($row->total, 0, ',', '.') }}</td>
                                        <td>
                                            <a class="btn btn-xs btn-warning btn-delete" title="Delete"
                                                href="javascript:;"
                                                onclick="swal({
                                                title: &quot;Are you sure ?&quot;,
                                                text: &quot;You will not be able to recover this record data!&quot;,
                                                type: &quot;warning&quot;,
                                                showCancelButton: true,
                                                confirmButtonColor: &quot;#ff0000&quot;,
                                                confirmButtonText: &quot;Yes!&quot;,
                                                cancelButtonText: &quot;No&quot;,
                                                closeOnConfirm: false },
                                                function(){  location.href=&quot;{{ CRUDBooster::mainpath('delete/' . $row->id) }}?&quot; });"><i
                                                    class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="warning">
                                        <td colspan="5" align="center">
                                            <i class="fa fa-search"></i> No Data Avaliable
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                            <tfoot>
                                <tr>
                                <tr class="active">
                                    <th width="auto">Created at</th>
                                    <th width="auto">Nama Produk</th>
                                    <th width="auto">Harga</th>
                                    <th width="auto">Jumlah</th>
                                    <th width="auto">Total</th>
                                    <th width="auto">Aksi</th>
                                </tr>
                                </tr>
                            </tfoot>
                        </table>

                        <!-- ADD A PAGINATION -->
                        <p>{!! urldecode(str_replace('/?', '?', $results->appends(Request::all())->render())) !!}</p>

                        <div style="display: flex;align-items: end;flex-direction: column;">
                            <table style="width: 100%">
                                    <tr>
                                        <td style="width: 80%" align="right">Total</td>
                                        <td style="width: 10%" align="center">:</td>
                                        <td style="width: 10%">Rp. {{ number_format($parent->total, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
@push('head')
    <link rel="stylesheet" href="{{ url('/vendor/crudbooster/assets/adminlte/plugins/datepicker/datepicker3.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@endpush
@push('bottom')
    <script src="{{ url('/vendor/crudbooster/assets/adminlte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script type="text/javascript">
        var lang = 'en';
        $(function() {
            $('.input_date').datepicker({
                format: 'yyyy-mm-dd',
                language: lang
            });

            $('.open-datetimepicker').click(function() {
                $(this).next('.input_date').datepicker('show');
            });

        });

        document.addEventListener('alpine:init', () => {
            Alpine.data('products', () => ({
                products: [],
                initSelect2() {
                    $('.select2').select2({
                        placeholder: 'Select an item',
                        ajax: {
                            url: '{{ CRUDBooster::adminPath('products/data') }}',
                            dataType: 'json',
                            delay: 250,
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(item) {
                                        return {
                                            text: `${item.name}, Satuan: ${item.unit_name}, Stok: ${item.quantity}`,
                                            id: item.id,
                                            quantity: item.quantity,
                                        }
                                    })
                                };
                            },
                            cache: true,
                        }
                    });

                    $('.select2').on('change', function() {
                        let data = $(this).select2('data');
                        let quantity = data[0].quantity ? data[0].quantity : 0;
                        let index = $(this).attr('name').match(/\[(.*?)\]/)[1];
                        console.log(index);
                        $('input[name="items[' + index + '][quantity_system]"]').val(quantity);
                    });
                },
                addProduct() {
                    this.products.push({
                        product_id: '',
                        quantity: '',
                    });

                    this.$nextTick(() => {
                        this.initSelect2();
                    });
                },
                removeProduct(index) {
                    this.products.splice(index, 1);
                },
            }));
        })
    </script>
@endpush
