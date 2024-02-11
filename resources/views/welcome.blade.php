@extends('layouts.app')
@section('css')
    <style>

        .pos .pos-container {
            display: block;
        }

        .pos .pos-sidebar .pos-order {
            display: block;
        }
        @media (max-width: 991.98px) {
            .pos .pos-container, .pos-sidebar {
                display: block !important;
                position: relative !important;
            }
        }

    </style>
@stop
@section('content')
    @foreach ($orderTables as $key => $value)
        <div class="pos card mb-3" data-id="{{ $value['id'] }}" id="{{'pos-'. $value['id']}}" ondrop="drop(event)"
             ondragover="allowDrop(event)" draggable="true" ondragstart="drag(event)">
            <div class="pos-container card-body">
                <div class="pos-sidebar" draggable="false">
                    <div class="h-100 d-flex flex-column p-0" draggable="false">
                        <div class="pos-sidebar-body tab-content ps ps--active-y" draggable="false">
                            <div class="pos-order" data-id="{{$value['id']}}" draggable="false">
                                <div class="pos-order-product" draggable="false">
                                    <div class="img" style="background-image: url('assets/img/pos/product-2.jpg')"
                                         draggable="false"></div>
                                    <div class="flex-1" draggable="false">
                                        <div class="h6 mb-1" draggable="false">{{ $value['name'] }}</div>
                                        <div class="small" draggable="false">$12.99</div>
                                        <div class="small mb-2" draggable="false">- size: large</div>
                                    </div>
                                </div>
                                <div class="pos-order-price" draggable="false">
                                    $12.99
                                </div>
                                @foreach($value['children'] as $child)
                                    <div class="pos card mb-3" data-id="{{ $child['id'] }}" id="{{'pos-'. $child['id']}}"
                                         ondrop="drop(event)" ondragover="allowDrop(event)" draggable="true"
                                         ondragstart="drag(event)">
                                        <div class="pos-container card-body">
                                            <div class="pos-sidebar" draggable="false">
                                                <div class="h-100 d-flex flex-column p-0" draggable="false">
                                                    <div class="pos-sidebar-body tab-content ps ps--active-y"
                                                         draggable="false">
                                                        <div class="pos-order" data-id="{{$child['id']}}" draggable="false">
                                                            <div class="pos-order-product" draggable="false">
                                                                <div class="img"
                                                                     style="background-image: url('assets/img/pos/product-2.jpg')"
                                                                     draggable="false"></div>
                                                                <div class="flex-1" draggable="false">
                                                                    <div class="h6 mb-1"
                                                                         draggable="false">{{ $child['name'] }}</div>
                                                                    <div class="small" draggable="false">$12.99</div>
                                                                    <div class="small mb-2" draggable="false">- size:
                                                                        large
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="pos-order-price" draggable="false">
                                                                $12.99
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-arrow">
                                            <div class="card-arrow-top-left"></div>
                                            <div class="card-arrow-top-right"></div>
                                            <div class="card-arrow-bottom-left"></div>
                                            <div class="card-arrow-bottom-right"></div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card-arrow">
                <div class="card-arrow-top-left"></div>
                <div class="card-arrow-top-right"></div>
                <div class="card-arrow-bottom-left"></div>
                <div class="card-arrow-bottom-right"></div>
            </div>
        </div>
    @endforeach

@endsection
@section('js')
    <script>

        let parentId = null;
        let childId = null;

        function allowDrop(ev) {
            // ev.preventDefault();
            // chỉ cho phép drop vào thẻ div có id là pos-container
            console.log('ev.target.classname', ev.target.className)
            if (ev.target.className === 'pos-order') {
                ev.preventDefault();
            } else {
                return false;
            }
        }

        function drag(ev) {
            childId = ev.target.getAttribute('data-id')
            console.log('parentId', childId)
            ev.dataTransfer.setData("text", ev.target.id);
        }

        function drop(ev) {
            ev.preventDefault();
            parentId = ev.target.getAttribute('data-id')
            var data = ev.dataTransfer.getData("text");
            ev.target.appendChild(document.getElementById(data));

            fetch('/api/order-tables/' + childId, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    parent_id: parentId
                })
                // done

            }).then(response => response.json())
                .then(data => {
                    console.log('data', data)
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }

    </script>
@stop
