<table class="border-collapse w-full my-5">
    <thead>
        <tr>
            <th class="w-6/12 bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">項目</th>
            <th class="w-6/12 bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">登録内容</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 0; $i < count($labels); $i++)
            <tr>
                <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$labels[$i]}}
                </td>
                <td class="break-all bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                    {{$data[$i]}}
                </td>
            </tr>
        @endfor
    </tbody>
</table>