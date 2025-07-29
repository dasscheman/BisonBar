<x-body-layout :title="$title">
    <div class="card card-header shadow-blur mx-6 mt-custom opacity-9">

    </div>
    <div class="card card-body shadow-blur mx-6 mt-1 opacity-9">
        @include('components.alert')
        <div class="row justify-content-center">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>year</th>
                        <th>credit</th>
                        <th>debit</th>
                        <th>netto</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($data as $key => $item)
                        <tr>
                            <td>{{$key}}</td>
                            <td>{{$item['credit']}}</td>
                            <td>{{$item['debit']}}</td>
                            <td>{{$item['netto']}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No user found...</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-body-layout>
