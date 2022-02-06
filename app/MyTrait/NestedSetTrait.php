<?php

namespace App\MyTrait;

use Illuminate\Support\Facades\DB;

trait NestedSetTrait
{
    public function removeNode($id, $options = 'branch')
    {
        $this->id = $id;
        if ($options == 'branch' || $options == null) $this->removeBranch();
        if ($options == 'one') $this->removeOne();
    }

    protected function removeBranch()
    {
        //  1. Lay thong cua node bi xoa
        $infoNodeRemove  = $this->getNodeInfo($this->id);

        //  2. Tinh chieu dai cua nhanh chung muon xoa
        $widthNodeRemove = $this->widthNode($infoNodeRemove->lft, $infoNodeRemove->rgt);

        //  3. Xoa nhanh
        DB::table($this->table)->whereBetween('lft', [$infoNodeRemove->lft, $infoNodeRemove->rgt])->delete();

        //  4. Cap nhat lai cai gia tri left - right của cay
        DB::table($this->table)->where('lft', '>', $infoNodeRemove->rgt)->update(['lft' => DB::raw("lft - $widthNodeRemove")]);
        DB::table($this->table)->where('rgt', '>', $infoNodeRemove->rgt)->update(['rgt' => DB::raw("rgt - $widthNodeRemove")]);
    }

    protected function removeOne()
    {
        $nodeInfo = $this->getNodeInfo($this->id);

        $result = DB::table($this->table)->select('id')->where('parent', $this->id)->orderBy('lft', 'desc')->get();

        while ($result) {
            $childIds[] = $result->id;
        }

        if (count($childIds) > 0) {
            foreach ($childIds as $val) {
                $id = $val;
                $parent = $nodeInfo->parent;
                $options = [
                    'position' => 'after',
                    'brother_id' => $nodeInfo->id
                ];
                $this->moveNode($id, $parent, $options);
            }
            $this->removeNode($nodeInfo->id);
        }
    }

    public  function  updateNode($data, $id = null, $newParentID = 0, $options)
    {
        if ($id != 0 && $id > 0 && count($data) != 0) {

            DB::table($this->table)->where('id', $id)->update($data);

            $infoNode = $this->getNodeInfo($id);

            if ($newParentID > 0 && $newParentID != null) {
                if ($infoNode->parent != $newParentID) {
                    $this->moveNode($id, $newParentID, $options);
                }
            }
        }
    }

    public function moveNode($id, $parent, $options)
    {
        $this->id = $id;
        $this->parent_id = $parent;

        switch ($options['position']) {
            case 'right':
                $this->moveRight();
                break;
            case 'left':
                $this->moveLeft();
                break;
            case 'before':
                $this->moveBefore($options['brother_id']);
                break;
            case 'after':
                $this->moveAfter($options['brother_id']);
                break;
        }
    }

    public function moveUp($id)
    {
        $infoMoveNode = $this->getNodeInfo($id);

        $infoBrotherNode = DB::table($this->table)->whereColumn([
            ['parent', '=', $infoMoveNode->parent],
            ['lft', '<', $infoMoveNode->lft],
        ])->orderBy('lft', 'desc')->limit(1)->get();

        if (!empty($infoBrotherNode)) {
            $options = array('position' => 'before', 'brother_id' => $infoBrotherNode->id);
            $this->moveNode($id, $infoMoveNode->parent, $options);
        }
    }

    public function moveDown($id)
    {
        $infoMoveNode = $this->getNodeInfo($id);

        $infoParentNode = $this->getNodeInfo($infoMoveNode->parent);

        $infoBrotherNode = DB::table($this->table)->whereColumn([
            ['parent', '=', $infoMoveNode->parent],
            ['lft', '>', $infoMoveNode->lft],
        ])->orderBy('lft', 'asc')->limit(1)->get();

        if (!empty($infoBrotherNode)) {
            $options = [
                'position' => 'after',
                'brother_id' => $infoBrotherNode->id
            ];
            $this->moveNode($id, $infoMoveNode->parent, $options);
        }
    }

    protected function moveRight()
    {
        $infoMoveNode = $this->getNodeInfo($this->id);

        $lftMoveNode = $infoMoveNode->lft; // 3
        $rgtMoveNode = $infoMoveNode->rgt; // 6

        //  1. Tach nhanh khoi cay
        DB::table($this->table)->whereBetween('lft', [$lftMoveNode, $rgtMoveNode])
            ->update([
                'lft' => DB::raw("lft - $lftMoveNode"),
                'rgt' => DB::raw("rgt - $rgtMoveNode")
            ]);

        //  2. Tinh do dai cua nhanh chung ta cat
        $widthMoveNode = $this->widthNode($lftMoveNode, $rgtMoveNode);

        //  3. Cap nhat gia tri cac node nam ben phai cua node tach
        DB::table($this->table)->where('lft', '>', $rgtMoveNode)->update(['lft' => DB::raw("lft - $widthMoveNode")]);
        DB::table($this->table)->where('rgt', '>', $rgtMoveNode)->update(['rgt' => DB::raw("rgt - $widthMoveNode")]);

        //  4. Lay ra thong thong tin cua node cha ($infoParentNode)
        $infoParentNode = $this->getNodeInfo($this->parent_id);
        $rgtParentNode = $infoParentNode->rgt;

        // 5. Cap nhat cac gia tri truoc khi gan nhanh vao
        DB::table($this->table)->where('lft', '>', $rgtParentNode)->update(['lft' => DB::raw("lft + $widthMoveNode")]);
        DB::table($this->table)->where('rgt', '>=', $rgtParentNode)->update(['rgt' => DB::raw("rgt + $widthMoveNode")]);

        // 6. Cap nhat level cho nhanh sap dc gan vao cay
        $levelMoveNode = $infoMoveNode->level;
        $levelParentNode = $infoParentNode->level;

        DB::table($this->table)->where('rgt', '<=', 0)->update(['level' => DB::raw("level - $levelMoveNode + $levelParentNode + 1")]);

        // 7. Cap nhat nhanh truoc khi gan vao node moi
        $infoParentNodeRight = $infoParentNode->rgt;
        DB::table($this->table)->where('rgt', '<=', 0)->update(['lft' => DB::raw("lft + $infoParentNodeRight")]);
        DB::table($this->table)->where('rgt', '<=', 0)->update(['rgt' => DB::raw("rgt + $infoParentNodeRight + $widthMoveNode - 1")]);

        // 8. Gan vao node cha
        DB::table($this->table)->where('id', $infoMoveNode->id)->update(['parent' => $infoParentNode->id]);
    }

    protected function moveLeft()
    {
        $infoMoveNode = $this->getNodeInfo($this->id);

        $lftMoveNode = $infoMoveNode->lft; // 3
        $rgtMoveNode = $infoMoveNode->rgt; // 6

        //  1. Tach nhanh khoi cay
        DB::table($this->table)->whereBetween('lft', [$lftMoveNode, $rgtMoveNode])
            ->update([
                'lft' => DB::raw("lft - $lftMoveNode"),
                'rgt' => DB::raw("rgt - $rgtMoveNode")
            ]);

        //  2. Tinh do dai cua nhanh chung ta cat
        $widthMoveNode = $this->widthNode($lftMoveNode, $rgtMoveNode);

        //  3. Cap nhat gia tri cac node nam ben phai cua node tach
        DB::table($this->table)->where('lft', '>', $rgtMoveNode)->update(['lft' => DB::raw("lft - $widthMoveNode")]);
        DB::table($this->table)->where('rgt', '>', $rgtMoveNode)->update(['rgt' => DB::raw("rgt - $widthMoveNode")]);

        //  4. Lay ra thong thong tin cua node cha ($infoParentNode)
        $infoParentNode = $this->getNodeInfo($this->parent_id);
        $lftParentNode = $infoParentNode->lft;

        // 5. Cap nhat cac gia tri truoc khi gan nhanh vao
        DB::table($this->table)->where('lft', '>', $lftParentNode)->update(['lft' => DB::raw("lft + $widthMoveNode")]);
        DB::table($this->table)->where('rgt', '>', $lftParentNode)->update(['rgt' => DB::raw("rgt + $widthMoveNode")]);

        // 6. Cap nhat level cho nhanh sap dc gan vao cay
        $levelMoveNode = $infoMoveNode->level;
        $levelParentNode = $infoParentNode->level;

        DB::table($this->table)->where('rgt', '<=', 0)->update(['level' => DB::raw("level - $levelMoveNode + $levelParentNode + 1")]);

        // 7. Cap nhat nhanh truoc khi gan vao node moi
        $infoParentNodeLeft = $infoParentNode->lft;
        DB::table($this->table)->where('rgt', '<=', 0)->update(['lft' => DB::raw("lft + $infoParentNodeLeft + 1")]);
        DB::table($this->table)->where('rgt', '<=', 0)->update(['rgt' => DB::raw("rgt + $infoParentNodeLeft +  $widthMoveNode")]);

        // 8. Gan vao node cha
        DB::table($this->table)->where('id', $infoMoveNode->id)->update(['parent' => $infoParentNode->id]);
    }

    protected function moveBefore($brother_id)
    {
        $infoMoveNode = $this->getNodeInfo($this->id);

        $lftMoveNode = $infoMoveNode->lft; // 3
        $rgtMoveNode = $infoMoveNode->rgt; // 6

        //  1. Tach nhanh khoi cay
        DB::table($this->table)->whereBetween('lft', [$lftMoveNode, $rgtMoveNode])
            ->update([
                'lft' => DB::raw("lft - $lftMoveNode"),
                'rgt' => DB::raw("rgt - $rgtMoveNode")
            ]);

        //  2. Tinh do dai cua nhanh chung ta cat
        $widthMoveNode = $this->widthNode($lftMoveNode, $rgtMoveNode);

        //  3. Cap nhat gia tri cac node nam ben phai cua node tach
        DB::table($this->table)->where('lft', '>', $rgtMoveNode)->update(['lft' => DB::raw("lft - $widthMoveNode")]);
        DB::table($this->table)->where('rgt', '>', $rgtMoveNode)->update(['rgt' => DB::raw("rgt - $widthMoveNode")]);

        //  4. Lay ra thong thong tin cua node cha ($infoParentNode)
        $infoParentNode = $this->getNodeInfo($this->parent_id);

        //  5. Lay gia tri cua node brother ($infoBrotherNode)
        $infoBrotherNode = $this->getNodeInfo($brother_id);
        $lftBrotherNode  = $infoBrotherNode->lft;

        // 6. Cap nhat cac gia tri truoc khi gan nhanh vao
        DB::table($this->table)->where('lft', '>=', $lftBrotherNode)->update(['lft' => DB::raw("lft + $widthMoveNode")]);
        DB::table($this->table)->where('rgt', '>', $lftBrotherNode)->update(['rgt' => DB::raw("rgt + $widthMoveNode")]);

        // 7. Cap nhat level cho nhanh sap dc gan vao cay
        $levelMoveNode   = $infoMoveNode->level;
        $levelParentNode = $infoParentNode->level;

        DB::table($this->table)->where('rgt', '<=', 0)->update(['level' => DB::raw("level - $levelMoveNode + $levelParentNode + 1")]);

        // 8. Cap nhat nhanh truoc khi gan vao node moi
        DB::table($this->table)->where('rgt', '<=', 0)->update(['lft' => DB::raw("lft + $lftBrotherNode")]);
        DB::table($this->table)->where('rgt', '<=', 0)->update(['rgt' => DB::raw("rgt + $lftBrotherNode + $widthMoveNode - 1")]);

        // 9. Gan vao node cha
        DB::table($this->table)->where('id', $infoMoveNode->id)->update(['parent' => $infoParentNode->id]);
    }

    protected function moveAfter($brother_id)
    {
        $infoMoveNode = $this->getNodeInfo($this->id);

        $lftMoveNode = $infoMoveNode->lft; // 3
        $rgtMoveNode = $infoMoveNode->rgt; // 6
        //  1. Tach nhanh khoi cay
        DB::table($this->table)->whereBetween('lft', [$lftMoveNode, $rgtMoveNode])
            ->update([
                'lft' => DB::raw("lft - $lftMoveNode"),
                'rgt' => DB::raw("rgt - $rgtMoveNode")
            ]);

        //  2. Tinh do dai cua nhanh chung ta cat
        $widthMoveNode = $this->widthNode($lftMoveNode, $rgtMoveNode);

        //  3. Cap nhat gia tri cac node nam ben phai cua node tach
        DB::table($this->table)->where('lft', '>', $rgtMoveNode)->update(['lft' => DB::raw("lft - $widthMoveNode")]);
        DB::table($this->table)->where('rgt', '>', $rgtMoveNode)->update(['rgt' => DB::raw("rgt - $widthMoveNode")]);

        //  4. Lay ra thong thong tin cua node cha ($infoParentNode)
        $infoParentNode = $this->getNodeInfo($this->parent_id);

        //  5. Lay gia tri cua node brother ($infoBrotherNode)
        $infoBrotherNode = $this->getNodeInfo($brother_id);
        $rgtBrotherNode  = $infoBrotherNode->rgt;

        // 6. Cap nhat cac gia tri truoc khi gan nhanh vao
        DB::table($this->table)->where('lft', '>', $rgtBrotherNode)->update(['lft' => DB::raw("lft + $widthMoveNode")]);
        DB::table($this->table)->where('rgt', '>', $rgtBrotherNode)->update(['rgt' => DB::raw("rgt + $widthMoveNode")]);

        // 7. Cap nhat level cho nhanh sap dc gan vao cay
        $levelMoveNode = $infoMoveNode->level;
        $levelParentNode = $infoParentNode->level;

        DB::table($this->table)->where('rgt', '<=', 0)->update(['level' => DB::raw("level - $levelMoveNode + $levelParentNode + 1")]);

        // 8. Cap nhat nhanh truoc khi gan vao node moi
        DB::table($this->table)->where('rgt', '<=', 0)->update(['lft' => DB::raw("lft + $rgtBrotherNode + 1")]);
        DB::table($this->table)->where('rgt', '<=', 0)->update(['rgt' => DB::raw("rgt + $rgtBrotherNode + $widthMoveNode")]);

        // 9. Gan vao node cha
        DB::table($this->table)->where('id', $infoMoveNode->id)->update(['parent' => $infoParentNode->id]);
    }

    public function widthNode($lftMoveNode, $rgtMoveNode)
    {
        $widthMoveNode = $rgtMoveNode - $lftMoveNode + 1;
        return $widthMoveNode;
    }

    public function insertNode($data, $parent = 1, $options)
    {
        $this->data      = $data;
        $this->parent_id = $parent;

        switch ($options['position']) {
            case 'right':
                $this->insertRight();
                break;
            case 'left':
                $this->insertLeft();
                break;
            case 'before':
                $this->insertBefore($options['brother_id']);
                break;
            case 'after':
                $this->insertAfter($options['brother_id']);
                break;
        }
    }

    protected function insertAfter($brother_id)
    {
        $parentInfo   = $this->getNodeInfo($this->parent_id);
        $brothderInfo = $this->getNodeInfo($brother_id);

        //update left
        DB::table($this->table)->where('lft', '>', $brothderInfo->rgt)->update(['lft' => DB::raw('lft + 2')]);
        //update right
        DB::table($this->table)->where('rgt', '>', $brothderInfo->rgt + 1)->update(['rgt' => DB::raw('rgt + 2')]);

        $data = $this->data;
        $data['parent']     = $parentInfo->id; //$this->parent_id
        $data['lft']        = $brothderInfo->rgt + 1;
        $data['rgt']        = $brothderInfo->rgt + 2;
        $data['level']      = $parentInfo->level + 1;

        DB::table($this->table)->insert($data);
    }

    protected function insertBefore($brother_id)
    {
        $parentInfo   = $this->getNodeInfo($this->parent_id);
        $brothderInfo = $this->getNodeInfo($brother_id);

        //update left
        DB::table($this->table)->where('lft', '>=', $brothderInfo->lft)->update(['lft' => DB::raw('lft + 2')]);
        //update right
        DB::table($this->table)->where('rgt', '>=', $brothderInfo->lft + 1)->update(['rgt' => DB::raw('rgt + 2')]);

        $data = $this->data;
        $data['parent']     = $parentInfo->id; //$this->parent_id
        $data['lft']        = $brothderInfo->lft;
        $data['rgt']        = $brothderInfo->lft + 1;
        $data['level']      = $parentInfo->level + 1;

        DB::table($this->table)->insert($data);
    }

    protected function insertLeft()
    {
        $parentInfo  = $this->getNodeInfo($this->parent_id);
        $parentLeft = $parentInfo->lft;

        //update left
        DB::table($this->table)->where('lft', '>=', $parentLeft + 1)->update(['lft' => DB::raw('lft + 2')]);
        //update right
        DB::table($this->table)->where('rgt', '>', $parentLeft + 1)->update(['rgt' => DB::raw('rgt + 2')]);

        $data = $this->data;
        $data['parent']     = $parentInfo->id; //$this->parent_id
        $data['lft']        = $parentLeft + 1;
        $data['rgt']        = $parentLeft + 2;
        $data['level']      = $parentInfo->level + 1;

        DB::table($this->table)->insert($data);
    }

    protected function insertRight()
    {
        $parentInfo  = $this->getNodeInfo($this->parent_id);
        $parentRight = $parentInfo->rgt;

        //update left
        DB::table($this->table)->where('lft', '>', $parentRight)->update(['lft' => DB::raw('lft + 2')]);
        //update right
        DB::table($this->table)->where('rgt', '>=', $parentRight)->update(['rgt' => DB::raw('rgt + 2')]);

        $data               = $this->data;
        $data['parent']     = $parentInfo->id; //$this->parent_id
        $data['lft']        = $parentRight;
        $data['rgt']        = $parentRight + 1;
        $data['level']      = $parentInfo->level + 1;

        DB::table($this->table)->insert($data);
    }

    public function getNodeInfo($id)
    {
        return DB::table($this->table)->find($id);
    }
}
