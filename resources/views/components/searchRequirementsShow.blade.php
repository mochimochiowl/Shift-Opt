<div class="p-4 mb-3 rounded-xl bg-blue-200">
    @component('components.h2',['title' => '検索ワード'])
    @endcomponent
    <table>
        <tr>
            <th class="w-3/12 bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                項目
            </th>
            <th class="w-3/12 bg-indigo-400 border border-black border-solid rounded-1g px-3 py-2">
                内容
            </th>
        </tr>
        @for ($i = 0; $i < count($search_requirement_labels); $i++)
        <tr>
            <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                {{$search_requirement_labels[$i]}}
            </td>
            <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                {{$search_requirements_data[$i]}}
            </td>
        </tr>
        @endfor
        <tr>
            <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                ヒット件数
            </td>
            <td class="bg-indigo-100 border border-black border-solid rounded-1g px-3 py-2">
                {{$count}}
            </td>
        </tr>
    </table>
</div>