<?php
namespace App\Repositories\RequestWriter;

interface RequestWriterRepositoryInterface
{
    /**
     * show List all requestWriter in admin page.
     *
     * @param  null
     *
     * @return $requestWriter
     */
    public function showRequestWriter();
}
