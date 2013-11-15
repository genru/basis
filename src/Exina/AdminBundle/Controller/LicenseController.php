<?php

namespace Exina\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Exina\AdminBundle\Model\Host;
use Exina\AdminBundle\Model\HostQuery;
use Exina\AdminBundle\Model\Key;
use Exina\AdminBundle\Model\KeyQuery;

class LicenseController extends Controller
{
    public function activeAction(Request $request)
    {
        $keyStr = $request->get('key');
        $fingerprint = $request->get('host');

        // 1) find host
        $host = HostQuery::create()->findOneByFingerprint($fingerprint);
        // 1.1 create it if no found
        if($host==null)
            $host = new Host();
        $host->setFingerprint($fingerprint);

        // 2) find ky
        $key = KeyQuery::create()->findOneByProductKey($keyStr);
        // 2.2 return error if no found
        if($key==null)
            return new Response("Invalid key", 404);

        // 3) check if paied
        if($key->getOrder()==null)
            return new Response("Not pay", 402);

        // 4) check key's bind host. if not empty, return erro
        $kHost = $key->getHost();
        if($kHost != null)
        {
            if($fingerprint===$kHost->getFingerprint())
                return new Response("actived on this machine already", 429);
            else
                return new Response("actived by other already", 400);
        }

        // 4) bind key and host
        $key->setHost($host);
        $key->save();

        return new Response("OK");
    }

    public function statusAction(Request $request)
    {
        $keyStr = $request->get('key');
        $fingerprint = $request->get('host');

        // 1) find ky
        $key = KeyQuery::create()->findOneByProductKey($keyStr);
        // 1.1 return error if no found
        if($key==null)
            return new Response("Invalid key", 404);

        // 2) check if paied
        if($key->getOrder()==null)
            return new Response("Not pay", 402);

        // 3) check key's bind host. if not empty, return erro
        $kHost = $key->getHost();
        if($kHost != null)
        {
            if($fingerprint===$kHost->getFingerprint())
                return new Response("successful", 200);      // bind already
            else
                return new Response("actived by other already", 400);   // not good
        }

        return new Response("Not active still", 200);
    }

}
