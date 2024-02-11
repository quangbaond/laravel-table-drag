<!DOCTYPE html>
<html lang="en">

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.2/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.css"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/jquery-treegrid@0.3.0/css/jquery.treegrid.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.2/dist/bootstrap-table.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* .has-card-view .treegrid-parent-1 td {
            background-color: #f8f9fa;
            padding-left: 20px
        }

        .has-card-view .treegrid-parent-2 td {
            background-color: #f8f9fa;
            padding-left: 20px
        }

        .has-card-view .treegrid-parent-3 td {
            background-color: #f8f9fa;
            padding-left: 20px
        } */

        .has-card-view [class^="treegrid-parent-"] td {
            padding-left: 20px !important;
        }



        /* treegrid-parent-* */
    </style>

</head>

<body>
    <div class="container">
        <table id="table" data-pagination="true" data-search="true" data-use-row-attr-func="true"
            data-reorderable-rows="true" data-ajax="ajaxRequest">
        </table>
    </div>

</body>


<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-treegrid@0.3.0/js/jquery.treegrid.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.2/dist/bootstrap-table.min.js"></script>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.2/dist/extensions/treegrid/bootstrap-table-treegrid.min.js">
</script>
<script src="https://cdn.jsdelivr.net/npm/tablednd@1.0.5/dist/jquery.tablednd.min.js"></script>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.22.2/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.min.js">
</script>
<script>
    $(document).ready(function() {
        var $table = $('#table')
        let showCardView = window.innerWidth <= 768
        $table.bootstrapTable({
            // cho phép kéo ra ngoài
            reorderableRows: true,
            idField: 'id',
            columns: [{
                    'field': 'id',
                    'title': 'id',
                },
                {
                    field: 'name',
                    title: 'name'
                },
                {
                    field: 'status',
                    title: 'status',
                    //   formatter: 'statusFormatter'
                },
                {
                    field: 'action',
                    title: 'action',
                    formatter: 'actionFormatter'
                }
            ],
            // cardView: showCardView,
            treeShowField: 'name',
            parentIdField: 'pid',
            onPostBody: function() {
                var columns = $table.bootstrapTable('getOptions').columns
                if (columns && columns[0][1].visible) {
                    $table.treegrid({
                        treeColumn: 1,
                        onChange: function() {
                            $table.bootstrapTable('resetView')
                        }
                    })
                }
            },
            // no records to display
            formatNoMatches: function() {
                return 'Không có dữ liệu hiển thị'
            },
            onReorderRow: function(e, dataDrag, dataDrop) {
                console.log(dataDrag, dataDrop);
                // kéo ra ngoài
                if (dataDrop === null) {
                    $.ajax({
                        url: `/api/test/${dataDrag?.id}`,
                        type: 'PUT',
                        data: {
                            parentId: 0
                        },
                        success: function(res) {
                            $table.bootstrapTable('refresh')
                        },
                        error: function() {
                            alert('Có lỗi xảy ra')
                            $table.bootstrapTable('refresh')
                        }
                    })
                    return
                }
                // $.ajax({
                //     url: `/api/test/${dataDrag?.id}`,
                //     type: 'PUT',
                //     data: {
                //         parentId: dataDrop?.id
                //     },
                //     success: function(res) {
                //         $table.bootstrapTable('refresh')
                //     },
                //     error: function() {
                //         $table.bootstrapTable('refresh')
                //     }
                // })
                // draw the table again
            }
        })
        $(document).on('click', '.revert', function(e) {
            e.preventDefault();

        let id = $(this).data('id');
        $.ajax({
            url: `/api/test/${id}`,
            type: 'PUT',
            data: {
                parentId: 0
            },
            success: function(res) {
                $table.bootstrapTable('refresh')
            },
            error: function() {
                alert('Có lỗi xảy ra')
                $table.bootstrapTable('refresh')
            }
        })
    })
    });

    function ajaxRequest(params) {
        var url = '/api/test'
        $.get(url + '?' + $.param(params.data)).then(function(res) {
            params.success(res)
        })
    }

    function actionFormatter(value, row, index) {
        if(row.pid === 0) {
            return ''
        }
        return [
            `<a data-id="${row.id}" class="btn btn-danger btn-sm revert" title="revert">
            <i class="fa-solid fa-clock-rotate-left"></i>
            </a>`
        ].join('')
    }


</script>