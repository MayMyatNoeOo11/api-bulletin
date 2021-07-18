<?php

namespace App\Exports;

use App\Models\Post;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
class PostsExport implements FromCollection,WithHeadings,  WithEvents, ShouldAutoSize
{
    use RegistersEventListeners;
     /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:I1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getStyle('A1:G1')->getAlignment()->setHorizontal('center');
                $event->sheet->getStyle('H1')->getAlignment()->setHorizontal('left');
                
               // $event->sheet->getDelegate()->getColumnDimension($column)->setWidth(20);

               $sheet = $event->sheet->getDelegate();
                $sheet->getStyle('A1:H1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFF0000');

          $event->sheet->getStyle('A1:H1')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
            
            }
        ];
    }

    public function headings():array{
        return[
            'id',
            'title',            
            'status',
            'created_user',
            'updated_user',
            'created_at',
            'updated_at',
            'description'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       // return Post::all();

       $postData=Post::leftjoin('users as u1','u1.id','=','posts.created_user_id')
       ->leftjoin('users as u2','u2.id','=','posts.updated_user_id')
       ->select('posts.id',
                'posts.title',                
                DB::raw('(CASE
                        WHEN posts.status = "0" THEN "Not Active"
                        ELSE "Active"
                        END) AS status'),
                'u1.name as created_user',
                'u2.name as updated_user',
                DB::raw('DATE_FORMAT(posts.created_at,\'%Y-%m-%d\') as cd'),
                DB::raw('DATE_FORMAT(posts.updated_at,\'%Y-%m-%d\') as ud'),
                'posts.description',)
       ->get();
       return $postData;

    }

}
