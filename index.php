<?php
// LB Painters - index.php
// Handles the enquiry form. Change $to if the inbox changes.
$to = 'lbpainters@outlook.com';
$status = '';
if (isset($_GET['sent'])) $status = 'ok';

// ---------------------------------------------------------------------------
// Customer reviews.
// TODO: replace the wording below with real customer reviews (Google / Facebook)
// before the site goes live. The attributions are deliberately role-based rather
// than invented names, so nothing here claims to be a specific person.
// The first entry is shown large; the rest are listed underneath. Add or remove
// entries freely - only the first is treated as the featured quote.
// ---------------------------------------------------------------------------
$reviews = [
    ['ico' => 'i-house',    'who' => 'Homeowner',          'town' => 'Didsbury',    'text' => 'Every wall was filled, sanded and lined before a drop of paint went on, and you can see it in the finish. Dust sheets down, furniture back where it started, and the whole job done in the time they promised.'],
    ['ico' => 'i-user',     'who' => 'Landlord',           'town' => 'Stockport',   'text' => 'Four rooms, the staircase and all the woodwork, painted while we were still living in the house. You would barely have known they were here.'],
    ['ico' => 'i-heart',    'who' => 'Care home manager',  'town' => 'Cheadle',     'text' => 'They worked around our residents\' routines, kept the corridors clear and left no smell of paint behind. Genuinely considerate.'],
    ['ico' => 'i-building', 'who' => 'Premises manager',   'town' => 'Altrincham',  'text' => 'Our unit was decorated over a weekend so we did not lose a trading day. Clean lines, and not a spot of mess left behind.'],
    ['ico' => 'i-sparkles', 'who' => 'Homeowner',          'town' => 'Wilmslow',    'text' => 'Booked in for an end of tenancy refresh and the flat was handed back spotless. Deposit returned without a question.'],
];
$clean = fn($v) => trim(str_replace(["\r", "\n"], ' ', strip_tags((string)$v)));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['website'])) {            // honeypot: bots fill this in
        $status = 'ok';
    } else {
        $n = $clean($_POST['n'] ?? '');
        $p = $clean($_POST['p'] ?? '');
        $e = filter_var($_POST['e'] ?? '', FILTER_VALIDATE_EMAIL) ?: '';
        $t = $clean($_POST['t'] ?? 'General');
        $m = trim(strip_tags($_POST['m'] ?? ''));
        if ($n === '' || ($p === '' && $e === '')) {
            $status = 'missing';
        } else {
            $host = preg_replace('/[^a-z0-9.\-]/i', '', $_SERVER['HTTP_HOST'] ?? 'localhost');
            $headers = "From: LB Painters Website <no-reply@{$host}>\r\n";
            if ($e) $headers .= "Reply-To: {$e}\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            $body = "Name: {$n}\nPhone: {$p}\nEmail: {$e}\nJob: {$t}\n\n{$m}\n";
            if (mail($to, "Quote enquiry: {$t}", $body, $headers)) {
                // Redirect so a refresh doesn't send the enquiry twice
                header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?') . '?sent=1#contact');
                exit;
            }
            $status = 'fail';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#FFC712">
<title>LB Painters | Professional Painter &amp; Decorator, Manchester &amp; Cheshire</title>
<meta name="description" content="Fully insured painter and decorator in Cheadle Hulme covering Manchester, Stockport and Cheshire. Interior, exterior, commercial, care homes and end of tenancy refreshes.">
<link rel="icon" type="image/png" href="images/favicon.png">
<link rel="apple-touch-icon" href="images/favicon.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,300..900&amp;display=swap" rel="stylesheet">
<style>
:root{--y:#FFC712;--ink:#0c0c0c;--wall:#ECEAE4;--bg:#F6F4EE;--fg:#0c0c0c;--mut:#5b5a55;--line:rgba(0,0,0,.18);box-sizing:border-box;padding-top:env(safe-area-inset-top,0px);padding-bottom:env(safe-area-inset-bottom,0px)}
@media (prefers-color-scheme:dark){:root:not([data-theme="light"]){--bg:#171716;--fg:#F2EFE6;--mut:#a5a299;--line:rgba(255,255,255,.2)}}
:root[data-theme="dark"]{--bg:#171716;--fg:#F2EFE6;--mut:#a5a299;--line:rgba(255,255,255,.2)}
*,*::before,*::after{box-sizing:inherit}
html{scroll-behavior:smooth;scroll-padding-top:86px}
body{margin:0;background:var(--bg);color:var(--fg);font-family:'Archivo','Helvetica Neue',Arial,sans-serif;font-stretch:100%;line-height:1.55;-webkit-font-smoothing:antialiased;overflow-x:clip}
a{color:inherit}
:focus-visible{outline:3px solid var(--ink);outline-offset:3px;box-shadow:0 0 0 6px var(--y)}
.wrap{max-width:1180px;margin:0 auto;padding:0 24px}
h1,h2,h3{font-stretch:125%;font-weight:800;line-height:1;margin:0;letter-spacing:-.01em}
.skip{position:absolute;left:-9999px;top:0;z-index:99;background:#0c0c0c;color:var(--y);padding:12px 18px;border-radius:0 0 8px 0;font-weight:700;text-decoration:none}
.skip:focus{left:0}
.ic{width:1em;height:1em;display:inline-block;vertical-align:-.14em;flex:none;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round}
.rv{opacity:0;transform:translateY(30px);transition:opacity .75s cubic-bezier(.2,.65,.3,1),transform .75s cubic-bezier(.2,.65,.3,1);transition-delay:var(--d,0s)}
.rv-l{opacity:0;transform:translateX(-32px);transition:opacity .8s cubic-bezier(.2,.65,.3,1),transform .8s cubic-bezier(.2,.65,.3,1);transition-delay:var(--d,0s)}
.rv-s{opacity:0;transform:scale(.96);transition:opacity .7s ease,transform .7s cubic-bezier(.2,.65,.3,1);transition-delay:var(--d,0s)}
.rv.in,.rv-l.in,.rv-s.in{opacity:1;transform:none}
.progress{position:fixed;top:0;left:0;height:3px;width:0;background:var(--y);z-index:75;pointer-events:none;transition:width .08s linear}
.topbar{position:fixed;top:0;left:0;right:0;z-index:60;background:rgba(12,12,12,.93);backdrop-filter:blur(10px);color:#F2EFE6;transform:translateY(-105%);transition:transform .5s cubic-bezier(.2,.7,.3,1);border-bottom:3px solid var(--y)}
.topbar.show{transform:none}
.topbar .wrap{display:flex;align-items:center;justify-content:space-between;gap:18px;padding-top:10px;padding-bottom:10px}
.topbar .logo{color:#F2EFE6;font-size:13px}
.topbar nav{display:flex;gap:20px;font-size:14px;font-weight:600}
.topbar nav a{display:inline-flex;align-items:center;gap:7px;text-decoration:none;color:rgba(242,239,230,.86);transition:color .2s}
.topbar nav a:hover{color:var(--y)}
.topbar nav a .ic{color:var(--y)}
.topbar .tel{padding:8px 16px;font-size:14px}
.totop{position:fixed;right:22px;bottom:22px;z-index:65;width:50px;height:50px;border-radius:50%;border:2px solid #0c0c0c;background:var(--y);color:#0c0c0c;display:grid;place-items:center;cursor:pointer;box-shadow:0 12px 26px rgba(0,0,0,.28);opacity:0;transform:translateY(18px) scale(.9);pointer-events:none;transition:opacity .35s,transform .35s}
.totop.show{opacity:1;transform:none;pointer-events:auto}
.totop:hover{transform:translateY(-3px)}
.totop .ic{width:20px;height:20px}
.lmark{width:38px;height:38px;border-radius:11px;background:#0c0c0c;overflow:hidden;flex:none;display:block;box-shadow:0 3px 10px rgba(0,0,0,.22)}
.lmark img{width:100%;height:100%;object-fit:cover;display:block;transform:scale(2.6);transform-origin:50% 26%}
.topbar .lmark,.mmenu .lmark{box-shadow:0 0 0 1px rgba(242,239,230,.22)}
.logo{display:flex;align-items:center;gap:12px;text-decoration:none;font-stretch:125%;font-weight:700;letter-spacing:.22em;font-size:15px}
.hero{position:relative;height:100svh;min-height:600px;overflow:hidden;background:#131211;--hc:#0c0c0c;--hb:rgba(12,12,12,.85)}
.hero.live{--hc:#F7F4EC;--hb:rgba(247,244,236,.72)}
.hero-bg{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:50% 45%;z-index:0;background:#131211 url(video/hero-poster.jpg) center 45%/cover no-repeat}
.hero-veil{position:absolute;inset:0;z-index:1;pointer-events:none;background:radial-gradient(120% 90% at 6% 84%,rgba(6,6,6,.72) 0%,rgba(6,6,6,.22) 45%,rgba(6,6,6,0) 68%),linear-gradient(100deg,rgba(6,6,6,.58) 0%,rgba(6,6,6,.26) 46%,rgba(6,6,6,.06) 100%),linear-gradient(0deg,rgba(6,6,6,.55) 0%,rgba(6,6,6,0) 42%),radial-gradient(140% 112% at 50% 44%,rgba(0,0,0,0) 52%,rgba(0,0,0,.42) 100%)}
.tape{position:absolute;left:0;right:0;height:26px;background:rgba(214,190,120,.5);mix-blend-mode:multiply;z-index:6;pointer-events:none;animation:wipeout .8s ease 1.45s forwards}
.tape.t{top:0}.tape.b{bottom:0}
.paintwipe{position:absolute;inset:0 auto 0 0;width:100%;background:var(--y);z-index:2;pointer-events:none;animation:reveal 1.3s cubic-bezier(.55,.1,.35,1) .25s backwards,wipeout .8s ease 1.45s forwards}
.inner{position:absolute;inset:0;z-index:4;width:100%;display:flex;flex-direction:column;justify-content:space-between;padding:26px 0 44px;will-change:opacity,transform;animation:heroin .8s cubic-bezier(.2,.7,.3,1) .5s backwards}
.nav{display:flex;justify-content:space-between;align-items:center;gap:16px}
.nav nav{display:flex;gap:20px;font-size:14.5px;font-weight:600}
.nav nav a{display:inline-flex;align-items:center;gap:8px;text-decoration:none;position:relative}
.nav nav a .ic{color:var(--hc);opacity:.72;transition:color .9s ease,opacity .25s}
.nav nav a::after{content:"";position:absolute;left:0;right:0;bottom:-6px;height:2px;background:var(--hc);transform:scaleX(0);transform-origin:left;transition:transform .3s cubic-bezier(.2,.7,.3,1)}
.nav nav a:hover::after{transform:scaleX(1)}
.nav nav a:hover .ic{opacity:1}
.tel{display:inline-flex;align-items:center;gap:9px;background:#0c0c0c;color:var(--y);padding:10px 18px;border-radius:99px;text-decoration:none;font-weight:700;font-size:15px;white-space:nowrap;transition:transform .2s,box-shadow .2s}
.tel:hover{transform:translateY(-2px);box-shadow:0 10px 22px rgba(0,0,0,.22)}
.tel .ic{width:17px;height:17px}
.burger{display:none;align-items:center;justify-content:center;width:44px;height:44px;border-radius:50%;border:2px solid #0c0c0c;background:transparent;color:#0c0c0c;cursor:pointer;transition:background .2s,color .2s}
.burger:hover{background:#0c0c0c;color:var(--y)}
.burger .ic{width:20px;height:20px}
.hero h1{font-size:clamp(46px,9.2vw,138px);max-width:11ch;font-weight:850;line-height:.92}
.hero .sub{display:flex;justify-content:space-between;align-items:flex-end;gap:24px;flex-wrap:wrap;margin-top:28px}
.hero p{max-width:34ch;margin:0;font-size:clamp(17px,1.6vw,21px);font-weight:500}
.reel-bar{position:absolute;left:0;right:0;bottom:0;height:4px;z-index:7;background:rgba(247,244,236,.16)}
.reel-bar i{display:block;height:100%;width:0;background:var(--y)}
/* Manual play/pause for the auto-playing film (cream on a dark pill, so it
   reads over both the yellow wall and the footage) */
.vb{position:absolute;right:18px;bottom:20px;z-index:8;width:44px;height:44px;display:grid;place-items:center;border-radius:50%;cursor:pointer;font:inherit;color:#F7F4EC;background:rgba(18,17,16,.46);border:1px solid rgba(247,244,236,.38);backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);transition:background .25s,border-color .25s,transform .2s}
.vb:hover{background:rgba(18,17,16,.7);border-color:rgba(247,244,236,.72);transform:translateY(-2px)}
.vb:focus-visible{outline:2px solid var(--y);outline-offset:2px}
.vb .ic{width:19px;height:19px}
.vb .ic-play{display:none}
.vb.is-paused .ic-pause{display:none}
.vb.is-paused .ic-play{display:block}
.btns{display:flex;gap:12px;flex-wrap:wrap}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:15px 26px;border-radius:99px;font-weight:700;text-decoration:none;border:2px solid #0c0c0c;font-size:16px;cursor:pointer;font-family:inherit;transition:transform .2s,background .25s,color .25s,box-shadow .25s}
.btn .ic{transition:transform .3s cubic-bezier(.2,.7,.3,1)}
.btn:hover{transform:translateY(-2px);box-shadow:0 12px 26px rgba(0,0,0,.16)}
.btn:hover .ic{transform:translateX(3px)}
.btn.solid{background:#0c0c0c;color:var(--y)}
.btn.solid:hover{background:#000}
.roller{position:absolute;top:50%;left:100%;z-index:3;width:clamp(170px,22vw,310px);transform:translate(-50%,-50%);pointer-events:none;filter:drop-shadow(0 14px 18px rgba(0,0,0,.25));animation:roll 1.3s cubic-bezier(.55,.1,.35,1) .25s backwards,gone .4s ease 1.5s forwards}
.cue{position:absolute;left:50%;bottom:40px;z-index:5;transform:translateX(-50%);display:inline-flex;flex-direction:column;align-items:center;gap:4px;font-size:10.5px;font-weight:800;letter-spacing:.24em;text-transform:uppercase;text-decoration:none;color:var(--hb);transition:color .9s ease,opacity .3s}
.cue:hover{color:var(--hc)}
.hero h1,.hero p,.hero .logo,.hero .cue{color:var(--hc);transition:color .9s ease}
.hero-copy{min-width:0;will-change:opacity,transform;text-shadow:0 2px 26px rgba(6,6,6,.55),0 1px 3px rgba(6,6,6,.35)}
.hero-eyebrow{display:inline-flex;align-items:center;gap:10px;margin:0 0 16px;font-size:13px;font-weight:700;letter-spacing:.18em;text-transform:uppercase;opacity:.88}
.hero-eyebrow .ic{width:18px;height:18px}
.hero .btn:not(.solid){color:var(--hc);border-color:var(--hb);transition:color .9s ease,border-color .9s ease,transform .2s,box-shadow .25s}
.cue .ic{width:18px;height:18px;animation:bob 1.8s ease-in-out infinite}
@keyframes reveal{from{width:0}to{width:100%}}
@keyframes wipeout{to{opacity:0;visibility:hidden}}
@keyframes heroin{from{opacity:0;transform:translateY(22px)}}
@keyframes roll{from{left:0}to{left:100%}}
@keyframes gone{to{opacity:0}}
@keyframes bob{0%,100%{transform:translateY(0)}50%{transform:translateY(6px)}}
section{padding:clamp(70px,10vw,130px) 0}
.lede{font-size:clamp(28px,4.4vw,58px);font-stretch:112%;font-weight:700;line-height:1.08;max-width:22ch;margin:0}
.eyebrow{display:inline-flex;align-items:center;gap:10px;margin:0 0 18px;font-size:13px;font-weight:700;letter-spacing:.18em;text-transform:uppercase;color:var(--mut)}
.eyebrow .ic{width:18px;height:18px;color:var(--y)}
.intro{display:grid;grid-template-columns:1.3fr 1fr;gap:clamp(30px,6vw,90px);align-items:end}
.intro p{color:var(--mut);font-size:18px;max-width:40ch;margin:0}
.intro p.eyebrow{color:var(--mut);font-size:13px;max-width:none}
.chart{margin-top:60px;border-top:2px solid var(--fg)}
.row{display:grid;grid-template-columns:150px 1fr 1.2fr;gap:24px;align-items:stretch;border-bottom:1px solid var(--line);padding:0;min-height:96px}
.chip{background:var(--c);display:flex;flex-direction:column;justify-content:flex-end;padding:10px 12px;font-size:11px;font-weight:600;color:rgba(0,0,0,.7);width:96px;transition:width .35s cubic-bezier(.3,.8,.3,1)}
.chip.lt{color:rgba(255,255,255,.85)}
.row:hover .chip,.row:focus-within .chip{width:100%}
.row h3{font-size:clamp(22px,2.6vw,34px);align-self:center;font-weight:750;display:flex;align-items:center;gap:14px}
.row h3 .ic{width:1em;height:1em;color:var(--mut);transition:color .3s,transform .3s}
.row:hover h3 .ic{color:var(--fg);transform:translateY(-2px) rotate(-6deg)}
.row p{align-self:center;margin:0;color:var(--mut);max-width:44ch;padding:14px 0}
.gal{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-top:52px}
.gal-item{position:relative;display:block;width:100%;aspect-ratio:1;padding:0;border:0;border-radius:12px;overflow:hidden;background:#111;cursor:zoom-in;font:inherit;color:#fff}
.gal-item img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .9s cubic-bezier(.2,.65,.3,1)}
.gal-item:hover img,.gal-item:focus-visible img{transform:scale(1.07)}
.gal-ov{position:absolute;inset:0;display:grid;place-items:center;background:linear-gradient(rgba(12,12,12,.1),rgba(12,12,12,.55));opacity:0;transition:opacity .35s}
.gal-ov .ic{width:20px;height:20px;box-sizing:content-box;padding:11px;border-radius:50%;background:rgba(12,12,12,.78);color:var(--y);transform:scale(.85);transition:transform .35s}
.gal-item:hover .gal-ov,.gal-item:focus-visible .gal-ov{opacity:1}
.gal-item:hover .gal-ov .ic,.gal-item:focus-visible .gal-ov .ic{transform:scale(1)}
.lb{position:fixed;inset:0;z-index:90;background:rgba(8,8,8,.94);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;opacity:0;visibility:hidden;transition:opacity .35s,visibility .35s}
.lb.open{opacity:1;visibility:visible}
.lb img{max-width:min(1100px,88vw);max-height:76vh;display:block;border-radius:12px;box-shadow:0 30px 80px rgba(0,0,0,.6);transform:scale(.96);transition:transform .4s cubic-bezier(.2,.7,.3,1)}
.lb.open img{transform:none}
.lb-cap{position:absolute;left:0;right:0;bottom:24px;text-align:center;color:#F2EFE6;font-weight:600;font-size:15px;letter-spacing:.1em;margin:0}
.lb-btn{position:absolute;width:50px;height:50px;border-radius:50%;border:2px solid rgba(242,239,230,.35);background:rgba(12,12,12,.6);color:var(--y);display:grid;place-items:center;cursor:pointer;transition:background .25s,color .25s,border-color .25s}
.lb-btn:hover{background:var(--y);color:#0c0c0c;border-color:var(--y)}
.lb-btn .ic{width:22px;height:22px}
.lb .prev{left:3vw;top:50%;transform:translateY(-50%)}
.lb .next{right:3vw;top:50%;transform:translateY(-50%)}
.lb .x{top:22px;right:22px}
.about-grid{display:grid;grid-template-columns:1fr 1.15fr;gap:clamp(40px,7vw,96px);align-items:center}
.about-media{position:relative}
.about-frame{border-radius:14px;overflow:hidden;border:2px solid var(--fg);box-shadow:20px 20px 0 var(--y);background:#111}
.about-frame img{width:100%;height:auto;display:block;transition:transform .8s cubic-bezier(.2,.65,.3,1)}
.about-frame:hover img{transform:scale(1.03)}
.about-badge{position:absolute;left:-14px;bottom:26px;display:inline-flex;align-items:center;gap:9px;background:#0c0c0c;color:var(--y);padding:11px 18px;border-radius:99px;font-weight:700;font-size:14px;box-shadow:0 14px 30px rgba(0,0,0,.28)}
.about-copy p.lead{font-size:18px;color:var(--mut);margin:0 0 16px;max-width:52ch}
.about-copy p.lead:last-of-type{margin-bottom:0}
.ticks{list-style:none;display:grid;grid-template-columns:1fr 1fr;gap:14px 24px;margin:30px 0;padding:0}
.ticks li{display:flex;align-items:flex-start;gap:11px;font-weight:600;font-size:15.5px}
.ticks .ic{width:22px;height:22px;color:var(--y);flex:none}
.about-cta{display:flex;gap:12px;flex-wrap:wrap;margin-top:28px}
.tester{background:#0c0c0c;color:#F2EFE6}
.tester .lede{color:#F2EFE6}
.tester .eyebrow{color:#a5a299}
.room{display:grid;grid-template-columns:1.5fr 1fr;gap:clamp(24px,5vw,70px);margin-top:50px;align-items:center}
.room svg{width:100%;height:auto;display:block;border-radius:4px}
#wall{transition:fill .6s ease}
.sw{display:grid;grid-template-columns:repeat(4,1fr);gap:12px}
.sw button{aspect-ratio:1;border:0;border-radius:50%;background:var(--c);cursor:pointer;box-shadow:inset 0 0 0 1px rgba(255,255,255,.25);transition:transform .2s;display:grid;place-items:center}
.sw button:hover{transform:scale(1.08)}
.sw button[aria-pressed="true"]{outline:3px solid var(--y);outline-offset:4px}
.sw button .ic{width:16px;height:16px;color:#fff;stroke-width:3;opacity:0;filter:drop-shadow(0 1px 3px rgba(0,0,0,.7));transition:opacity .25s}
.sw button[aria-pressed="true"] .ic{opacity:1}
.tester :focus-visible{outline-color:var(--y);box-shadow:none}
.pick{font-stretch:125%;font-weight:800;font-size:clamp(30px,4vw,52px);margin:0 0 22px;min-height:1.1em;display:flex;align-items:center;gap:14px}
.tester small{display:block;margin-top:24px;color:#a5a299;font-size:15px;max-width:34ch}
.band{background:var(--y);color:#0c0c0c;padding:0}
.band .wrap{display:grid;grid-template-columns:repeat(3,1fr)}
.band div{padding:clamp(34px,5vw,64px) 22px 34px 0;font-stretch:120%;font-weight:800;font-size:clamp(22px,3vw,38px);line-height:1.05}
.band .ic{width:34px;height:34px;display:block;margin-bottom:14px;stroke-width:1.7}
.band span{display:block;font-stretch:100%;font-weight:500;font-size:16px;margin-top:10px;max-width:26ch;line-height:1.4}
.band span a{color:inherit;font-weight:700;text-decoration:none;border-bottom:2px solid rgba(0,0,0,.3);transition:border-color .25s}
.band span a:hover{border-color:#0c0c0c}
.stars{display:flex;gap:4px;margin-bottom:12px}
.stars .ic{width:24px;height:24px;margin:0}
.areas{font-stretch:112%;font-weight:700;font-size:clamp(30px,5.6vw,80px);line-height:1.02;margin:40px 0 0;letter-spacing:-.015em}
.areas i{font-style:normal;color:var(--mut);font-weight:400}
.town{background-image:linear-gradient(transparent 64%,var(--y) 64%);background-repeat:no-repeat;background-size:0% 100%;transition:background-size .45s cubic-bezier(.2,.7,.3,1)}
.town:hover{background-size:100% 100%}
.contact{background:var(--wall);color:#0c0c0c}
.contact .cols{display:grid;grid-template-columns:1fr 1fr;gap:clamp(30px,6vw,90px)}
.big{display:flex;align-items:center;gap:14px;font-stretch:125%;font-weight:800;font-size:clamp(24px,3.2vw,42px);text-decoration:none;line-height:1.15;margin-top:22px;overflow-wrap:anywhere;transition:transform .25s}
.big:hover{transform:translateX(4px)}
.big:hover span{text-decoration:underline;text-decoration-color:var(--y);text-decoration-thickness:6px;text-underline-offset:6px}
.big .ic{width:.78em;height:.78em;padding:.16em;box-sizing:content-box;border-radius:50%;background:#0c0c0c;color:var(--y)}
form{display:grid;gap:14px}
label{font-size:14px;font-weight:600;display:grid;gap:6px}
label .lbl{display:inline-flex;align-items:center;gap:8px}
label .lbl .ic{width:16px;height:16px;color:var(--mut)}
input,select,textarea{font:inherit;padding:13px 14px;border:2px solid #0c0c0c;background:#fff;border-radius:6px;color:#0c0c0c;width:100%;transition:box-shadow .2s,border-color .2s}
input:focus,select:focus,textarea:focus{border-color:#0c0c0c;box-shadow:0 0 0 4px rgba(255,199,18,.55);outline:none}
textarea{min-height:110px;resize:vertical}
.note{margin:0;padding:12px 14px;border-radius:6px;font-weight:600;display:flex;align-items:center;gap:10px}
.note.ok{background:#0c0c0c;color:var(--y)}.note.bad{background:#fff;border:2px solid #b3261e;color:#b3261e}
footer{background:#0c0c0c;color:#F2EFE6;padding:52px 0 30px;font-size:15px}
footer a{color:#F2EFE6;text-decoration:none;transition:color .2s}
footer a:hover{color:var(--y)}
.fwrap{display:flex;justify-content:space-between;gap:34px;flex-wrap:wrap;align-items:flex-start}
.fbrand{display:flex;flex-direction:column;gap:16px;max-width:280px}
.flogo{width:170px;height:auto;display:block}
.fbrand small{color:#a5a299;font-size:13.5px;line-height:1.5}
.fnav,.fsoc{display:grid;gap:12px;font-weight:600;font-size:14.5px}
.fnav a,.fsoc a{display:inline-flex;align-items:center;gap:10px}
.fnav .ic,.fsoc .ic{width:17px;height:17px;color:var(--y)}
.fsoc .fb{background:#F2EFE6;color:#0c0c0c;padding:9px 16px;border-radius:99px;font-weight:700;transition:transform .2s,background .25s}
.fsoc .fb .ic{color:#0c0c0c}
.fsoc .fb:hover{background:var(--y);color:#0c0c0c;transform:translateY(-2px)}
.fsoc .fb:hover .ic{color:#0c0c0c}
.fbot{border-top:1px solid rgba(242,239,230,.14);margin-top:36px;padding-top:18px;display:flex;justify-content:space-between;gap:14px;flex-wrap:wrap;font-size:13.5px;color:#a5a299}
.fbot a{display:inline-flex;align-items:center;gap:8px;color:#F2EFE6}
.fbot .ic{width:16px;height:16px;color:var(--y)}
.mmenu{position:fixed;inset:0;z-index:85;background:#0c0c0c;color:#F2EFE6;padding:22px 0;display:flex;flex-direction:column;opacity:0;visibility:hidden;transform:translateY(-10px);transition:opacity .35s,transform .35s,visibility .35s}
.mmenu.open{opacity:1;visibility:visible;transform:none}
body.locked{overflow:hidden}
.mmenu .mhead{display:flex;align-items:center;justify-content:space-between;gap:16px}
.mmenu .close{background:transparent;border:2px solid rgba(242,239,230,.3);color:#F2EFE6;width:44px;height:44px;border-radius:50%;display:grid;place-items:center;cursor:pointer}
.mmenu .close:hover{border-color:var(--y);color:var(--y)}
.mmenu .mnav{display:grid;margin:auto 0}
.mmenu .mnav a{display:flex;align-items:center;gap:16px;padding:12px 0;font-size:clamp(21px,6vw,30px);font-stretch:120%;font-weight:800;text-decoration:none;border-bottom:1px solid rgba(242,239,230,.12)}
.mmenu .mnav a .ic{width:24px;height:24px;color:var(--y)}
.mmenu .mnav a:hover{color:var(--y)}
.mmenu .mfoot{display:flex;gap:18px;flex-wrap:wrap;font-weight:600;font-size:15px}
.mmenu .mfoot a{color:var(--y);display:inline-flex;align-items:center;gap:9px}
.mmenu .mfoot .ic{width:17px;height:17px}
/* ===== Reviews ===== */
.rev-sum{display:flex;align-items:center;gap:clamp(16px,3vw,34px);flex-wrap:wrap;margin-top:clamp(30px,4vw,44px);padding:20px 0;border-top:1px solid var(--line);border-bottom:1px solid var(--line)}
.rev-score{display:flex;align-items:baseline;gap:8px;font-stretch:125%;font-weight:800;font-size:clamp(32px,4.6vw,50px);line-height:1;letter-spacing:-.02em}
.rev-score small{font-size:14px;font-stretch:100%;font-weight:600;color:var(--mut);letter-spacing:0}
.rev-sum .stars{margin:0}
.rev-sum .stars .ic{width:21px;height:21px;color:var(--y)}
.rev-sum p{margin:0;color:var(--mut);font-size:15.5px;max-width:36ch}
.rev-src{margin-left:auto;display:inline-flex;align-items:center;gap:9px;font-weight:700;font-size:14.5px;text-decoration:none;padding-bottom:3px;border-bottom:2px solid var(--y);transition:color .25s,transform .25s}
.rev-src:hover{transform:translateY(-2px)}
.rev-src .ic{width:17px;height:17px;color:var(--y)}
.rev-wall{display:grid;grid-template-columns:1.2fr .95fr;gap:clamp(30px,5vw,70px);margin-top:clamp(34px,5vw,54px);align-items:start}

/* Featured quote: yellow spine + an oversized watermark mark, on a tint that
   follows --fg so it stays readable in both light and dark mode */
.rev-feat{margin:0;position:relative;padding:clamp(26px,3.2vw,42px) clamp(26px,3.2vw,42px) clamp(26px,3.2vw,42px) clamp(32px,4vw,54px);background:color-mix(in srgb,var(--fg) 5%,transparent)}
.rev-feat::before{content:"";position:absolute;left:0;top:0;bottom:0;width:5px;background:var(--y)}
.rev-mark{position:absolute;top:clamp(14px,2vw,24px);right:clamp(16px,2.4vw,28px);width:clamp(44px,5.6vw,72px);height:auto;fill:currentColor;stroke:none;color:var(--y);opacity:.26;pointer-events:none}
.rev-feat blockquote{margin:0;font-size:clamp(20px,2.3vw,31px);font-stretch:110%;font-weight:600;line-height:1.28;letter-spacing:-.01em}
.rev-who{display:flex;align-items:center;gap:12px;flex-wrap:wrap;margin:0;font-size:15px;color:var(--mut)}
.rev-feat .rev-who{margin-top:clamp(22px,3vw,30px);padding-top:18px;border-top:1px solid var(--line)}
.rev-av{width:46px;height:46px;border-radius:50%;background:var(--y);color:#0c0c0c;display:grid;place-items:center;flex:none}
.rev-av .ic{width:22px;height:22px}
.rev-who strong{color:var(--fg);font-weight:700;font-stretch:115%}
.rev-who .rev-town{color:var(--mut)}
.rev-tag{display:inline-flex;align-items:center;gap:4px;margin-left:auto;font-weight:700;font-size:14px;color:var(--fg)}
.rev-tag .ic{width:15px;height:15px;color:var(--y)}
.rev-list{list-style:none;margin:0;padding:0}
.rev-list li{position:relative;border-top:1px solid var(--line);padding:clamp(18px,2.4vw,26px) 0;transition:padding-left .4s cubic-bezier(.2,.7,.3,1)}
.rev-list li::before{content:"";position:absolute;left:0;top:0;bottom:0;width:3px;background:var(--y);transform:scaleY(0);transform-origin:top;transition:transform .45s cubic-bezier(.2,.7,.3,1)}
.rev-list li:hover{padding-left:20px}
.rev-list li:hover::before{transform:scaleY(1)}
.rev-list blockquote{margin:0 0 14px;font-size:16.5px;line-height:1.5;font-weight:500}
.rev-list .rev-av{width:34px;height:34px}
.rev-list .rev-av .ic{width:17px;height:17px}
@media(max-width:900px){.rev-wall{grid-template-columns:1fr}.rev-src{margin-left:0}}

@media(max-width:1100px){.nav nav,.topbar nav{display:none}.burger{display:inline-flex}.gal{grid-template-columns:repeat(3,1fr)}}
@media(max-width:900px){.intro,.room,.contact .cols,.about-grid{grid-template-columns:1fr}.about-media{max-width:520px}.cue{display:none}}
@media(max-width:820px){.row{grid-template-columns:88px 1fr;gap:16px}.row p{grid-column:2;padding-top:0}.chip{width:70px}.row h3{padding-top:14px;align-self:start;align-items:flex-start}.band .wrap{grid-template-columns:1fr}.band div{padding:26px 0;border-bottom:1px solid rgba(0,0,0,.2)}.roller{width:150px}.gal{grid-template-columns:repeat(2,1fr);gap:10px}.ticks{grid-template-columns:1fr}.lb .prev{left:10px;top:auto;bottom:70px;transform:none}.lb .next{right:10px;top:auto;bottom:70px;transform:none}.about-badge{left:0}}
@media(prefers-reduced-motion:reduce){.paintwipe,.roller,.tape,.cue .ic{animation:none}.paintwipe,.roller,.reel-bar{display:none}.inner{opacity:1;animation:none}.rv,.rv-l,.rv-s{opacity:1;transform:none;transition:none}.chip,.gal-item img,.gal-ov,.gal-ov .ic,.btn,.btn .ic,.topbar,.lb,.lb img,.totop,.mmenu,.town,.big,.rev-list li,.rev-list li::before{transition:none}}

/* ===== Mobile fixes ===== */
html,body{overflow-x:hidden}
.logo{white-space:nowrap}
.hero{height:auto;min-height:600px;min-height:max(600px,100svh)}
.inner{position:relative;inset:auto;min-height:600px;min-height:max(600px,100svh);gap:32px}
@media(max-width:900px){.intro,.room,.contact .cols,.about-grid{grid-template-columns:minmax(0,1fr)}}
@media(max-width:820px){.row{grid-template-columns:88px minmax(0,1fr);min-height:0}.chip{grid-row:1 / span 2;min-height:96px}.gal{grid-template-columns:repeat(2,minmax(0,1fr))}.ticks{grid-template-columns:minmax(0,1fr)}.band .wrap{grid-template-columns:minmax(0,1fr)}.about-frame{box-shadow:10px 10px 0 var(--y)}}
@media(max-width:640px){.wrap{padding:0 18px}.nav .tel,.topbar .tel{display:none}.logo{letter-spacing:.14em;font-size:13px;gap:10px}.inner{padding:18px 0 32px}.hero h1{font-size:clamp(40px,12.5vw,60px);max-width:none}.hero .sub{flex-direction:column;align-items:stretch;gap:20px}.hero .btns .btn{flex:1 1 100%}.big{font-size:clamp(17px,4.7vw,28px)}.about-cta .btn{flex:1 1 100%}}
</style>
</head>
<body>
<a class="skip" href="#work">Skip to content</a>

<svg width="0" height="0" style="position:absolute" aria-hidden="true">
<symbol id="mark" viewBox="475 185 365 440">
<line x1="505" y1="218" x2="572" y2="326" stroke="#0c0c0c" stroke-width="36" stroke-linecap="round"/>
<path d="M575 342 L612 404 L768 356 Q814 344 820 396 L806 428" fill="none" stroke="#fff" stroke-width="13" stroke-linecap="round" stroke-linejoin="round"/>
<g transform="translate(650 508) rotate(-24)"><rect x="-168" y="-44" width="336" height="88" rx="10" fill="#fff"/><rect x="-176" y="-44" width="24" height="88" rx="4" fill="#0c0c0c"/><rect x="152" y="-44" width="24" height="88" rx="4" fill="#0c0c0c"/></g>
</symbol>
<symbol id="i-phone" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.2 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></symbol>
<symbol id="i-mail" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></symbol>
<symbol id="i-pin" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></symbol>
<symbol id="i-palette" viewBox="0 0 24 24"><circle cx="13.5" cy="6.5" r=".6"/><circle cx="17.5" cy="10.5" r=".6"/><circle cx="8.5" cy="7.5" r=".6"/><circle cx="6.5" cy="12.5" r=".6"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.93 0 1.65-.75 1.65-1.69 0-.44-.18-.84-.44-1.13-.29-.29-.44-.65-.44-1.12a1.64 1.64 0 0 1 1.67-1.67h1.99c3.05 0 5.56-2.5 5.56-5.55C21.97 6.01 17.46 2 12 2z"/></symbol>
<symbol id="i-camera" viewBox="0 0 24 24"><path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/></symbol>
<symbol id="i-roller" viewBox="0 0 24 24"><rect x="2" y="3" width="16" height="6" rx="2"/><path d="M10 16v-2a2 2 0 0 1 2-2h8a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="8" y="16" width="4" height="6" rx="1"/></symbol>
<symbol id="i-house" viewBox="0 0 24 24"><path d="M15 21v-8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v8"/><path d="M3 10a2 2 0 0 1 .7-1.5l7-6a2 2 0 0 1 2.6 0l7 6A2 2 0 0 1 21 10v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></symbol>
<symbol id="i-building" viewBox="0 0 24 24"><rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01M12 6h.01M16 6h.01M8 10h.01M12 10h.01M16 10h.01M8 14h.01M12 14h.01M16 14h.01"/></symbol>
<symbol id="i-wall" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M3 15h18M9 3v6M15 9v6M9 15v6"/></symbol>
<symbol id="i-heart" viewBox="0 0 24 24"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7z"/></symbol>
<symbol id="i-presentation" viewBox="0 0 24 24"><path d="M2 3h20"/><path d="M21 3v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V3"/><path d="m7 21 5-5 5 5"/></symbol>
<symbol id="i-sparkles" viewBox="0 0 24 24"><path d="M12 3l1.9 5.6a2 2 0 0 0 1.3 1.3L21 12l-5.8 1.9a2 2 0 0 0-1.3 1.3L12 21l-1.9-5.8a2 2 0 0 0-1.3-1.3L3 12l5.8-2.1a2 2 0 0 0 1.3-1.3z"/><path d="M19 2v4M21 4h-4"/></symbol>
<symbol id="i-shield" viewBox="0 0 24 24"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></symbol>
<symbol id="i-star" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26" fill="currentColor" stroke="none"/></symbol>
<symbol id="i-check-circle" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="m8.5 12.5 2.5 2.5 4.5-5.5"/></symbol>
<symbol id="i-check" viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5"/></symbol>
<symbol id="i-users" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></symbol>
<symbol id="i-send" viewBox="0 0 24 24"><path d="m22 2-7 20-4-9-9-4z"/><path d="M22 2 11 13"/></symbol>
<symbol id="i-arrow-up" viewBox="0 0 24 24"><path d="m5 12 7-7 7 7"/><path d="M12 19V5"/></symbol>
<symbol id="i-arrow-right" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></symbol>
<symbol id="i-chev-down" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"/></symbol>
<symbol id="i-chev-left" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></symbol>
<symbol id="i-chev-right" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></symbol>
<symbol id="i-pause" viewBox="0 0 24 24"><rect x="7" y="5" width="3.5" height="14" rx="1"/><rect x="13.5" y="5" width="3.5" height="14" rx="1"/></symbol>
<symbol id="i-play" viewBox="0 0 24 24"><path d="M8 5.14v13.72a1 1 0 0 0 1.52.86l10.6-6.86a1 1 0 0 0 0-1.72L9.52 4.28A1 1 0 0 0 8 5.14Z"/></symbol>
<symbol id="i-quote" viewBox="0 0 24 24"><path d="M10.7 4.5C7 6.3 4.8 9.3 4.8 13c0 3.6 2.1 6 5.2 6 2.4 0 4.2-1.7 4.2-4 0-2.2-1.6-3.9-3.8-3.9-.4 0-.9.1-1.1.2.5-2 2-3.8 4.1-5.1l-2.7-1.7zm9.4 0c-3.7 1.8-5.9 4.8-5.9 8.5 0 3.6 2.1 6 5.2 6 2.4 0 4.2-1.7 4.2-4 0-2.2-1.6-3.9-3.8-3.9-.4 0-.9.1-1.1.2.5-2 2-3.8 4.1-5.1l-2.7-1.7z"/></symbol>
<symbol id="i-menu" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></symbol>
<symbol id="i-close" viewBox="0 0 24 24"><path d="M18 6 6 18M6 6l12 12"/></symbol>
<symbol id="i-expand" viewBox="0 0 24 24"><path d="M15 3h6v6"/><path d="m21 3-7 7"/><path d="M9 21H3v-6"/><path d="m3 21 7-7"/></symbol>
<symbol id="i-facebook" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></symbol>
<symbol id="i-user" viewBox="0 0 24 24"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></symbol>
<symbol id="i-at" viewBox="0 0 24 24"><circle cx="12" cy="12" r="4"/><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.9 7.9"/></symbol>
<symbol id="i-clipboard" viewBox="0 0 24 24"><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4M12 16h4M8 11h.01M8 16h.01"/></symbol>
<symbol id="i-message" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></symbol>
</svg>

<noscript><style>.rv,.rv-l,.rv-s{opacity:1;transform:none}</style></noscript>
<div class="progress" id="progress" aria-hidden="true"></div>

<!-- Sticky header: slides in once you leave the hero -->
<div class="topbar" id="topbar">
  <div class="wrap">
    <a class="logo" href="#top" aria-label="LB Painters home"><span class="lmark"><img src="images/logo.png" alt="" width="38" height="38"></span>LB PAINTERS</a>
    <nav aria-label="Main">
      <a href="#work"><svg class="ic"><use href="#i-roller"/></svg>What we paint</a>
      <a href="#gallery"><svg class="ic"><use href="#i-camera"/></svg>Recent work</a>
      <a href="#about"><svg class="ic"><use href="#i-users"/></svg>About us</a>
      <a href="#colour"><svg class="ic"><use href="#i-palette"/></svg>Try a colour</a>
      <a href="#areas"><svg class="ic"><use href="#i-pin"/></svg>Areas</a>
      <a href="#contact"><svg class="ic"><use href="#i-mail"/></svg>Contact</a>
    </nav>
    <div style="display:flex;align-items:center;gap:12px">
      <a class="tel" href="tel:+447576668083"><svg class="ic"><use href="#i-phone"/></svg>07576 668083</a>
      <button class="burger" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="mmenu"><svg class="ic"><use href="#i-menu"/></svg></button>
    </div>
  </div>
</div>

<!-- Mobile menu -->
<div class="mmenu" id="mmenu" aria-hidden="true">
  <div class="wrap mhead">
    <a class="logo" href="#top" aria-label="LB Painters home"><span class="lmark"><img src="images/logo.png" alt="" width="38" height="38"></span>LB PAINTERS</a>
    <button class="close" type="button" aria-label="Close menu"><svg class="ic"><use href="#i-close"/></svg></button>
  </div>
  <nav class="wrap mnav" aria-label="Mobile">
    <a href="#work"><svg class="ic"><use href="#i-roller"/></svg>What we paint</a>
    <a href="#gallery"><svg class="ic"><use href="#i-camera"/></svg>Recent work</a>
    <a href="#about"><svg class="ic"><use href="#i-users"/></svg>About us</a>
    <a href="#reviews"><svg class="ic"><use href="#i-quote"/></svg>Reviews</a>
    <a href="#colour"><svg class="ic"><use href="#i-palette"/></svg>Try a colour</a>
    <a href="#areas"><svg class="ic"><use href="#i-pin"/></svg>Areas</a>
    <a href="#contact"><svg class="ic"><use href="#i-mail"/></svg>Contact</a>
  </nav>
  <div class="wrap mfoot">
    <a href="tel:+447576668083"><svg class="ic"><use href="#i-phone"/></svg>07576 668083</a>
    <a href="mailto:lbpainters@outlook.com"><svg class="ic"><use href="#i-at"/></svg>Email us</a>
    <a href="https://web.facebook.com/LBPainters5/" rel="noopener"><svg class="ic"><use href="#i-facebook"/></svg>Facebook</a>
  </div>
</div>

<header class="hero live" id="top">
  <video class="hero-bg" id="heroVideo" src="video/hero.mp4" poster="video/hero-poster.jpg" autoplay muted loop playsinline preload="auto" aria-hidden="true"></video>
  <div class="hero-veil" aria-hidden="true"></div>
  <div class="paintwipe" aria-hidden="true"></div>
  <div class="inner">
      <div class="wrap" style="width:100%">
        <div class="nav">
          <a class="logo" href="#top" aria-label="LB Painters home"><span class="lmark"><img src="images/logo.png" alt="" width="38" height="38"></span>LB PAINTERS</a>
          <nav aria-label="Main">
            <a href="#work"><svg class="ic"><use href="#i-roller"/></svg>What we paint</a>
            <a href="#gallery"><svg class="ic"><use href="#i-camera"/></svg>Recent work</a>
            <a href="#about"><svg class="ic"><use href="#i-users"/></svg>About us</a>
            <a href="#colour"><svg class="ic"><use href="#i-palette"/></svg>Try a colour</a>
            <a href="#areas"><svg class="ic"><use href="#i-pin"/></svg>Areas</a>
            <a href="#contact"><svg class="ic"><use href="#i-mail"/></svg>Contact</a>
          </nav>
          <div style="display:flex;align-items:center;gap:12px">
            <a class="tel" href="tel:+447576668083"><svg class="ic"><use href="#i-phone"/></svg>07576 668083</a>
            <button class="burger" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="mmenu"><svg class="ic"><use href="#i-menu"/></svg></button>
          </div>
        </div>
      </div>
      <div class="wrap" style="width:100%">
        <div class="hero-copy">
          <!-- <p class="hero-eyebrow"><svg class="ic"><use href="#i-camera"/></svg>Scroll to play our recent work</p> -->
          <h1>Painted properly, first time.</h1>
          <div class="sub">
            <p>Professional painter and decorator across Manchester, Stockport and Cheshire. Bespoke, premium finishes, fully insured.</p>
            <div class="btns">
              <a class="btn solid" href="#contact">Get a quote <svg class="ic"><use href="#i-arrow-right"/></svg></a>
              <a class="btn" href="tel:+447576668083"><svg class="ic"><use href="#i-phone"/></svg>Call now</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  <svg class="roller" viewBox="475 185 365 440" aria-hidden="true"><use href="#mark"/></svg>
  <a class="cue" href="#work" aria-label="Scroll to what we paint"><span>Scroll</span><svg class="ic"><use href="#i-chev-down"/></svg></a>
  <button class="vb" id="vToggle" type="button" aria-label="Pause background video">
    <svg class="ic ic-pause" aria-hidden="true"><use href="#i-pause"/></svg>
    <svg class="ic ic-play" aria-hidden="true"><use href="#i-play"/></svg>
  </button>
  <span class="reel-bar" aria-hidden="true"><i id="reelBar"></i></span>
  <div class="tape t"></div><div class="tape b"></div>
</header>

<section id="work">
  <div class="wrap">
    <div class="intro rv">
      <div>
        <p class="eyebrow"><svg class="ic"><use href="#i-roller"/></svg>What we paint</p>
        <h2 class="lede">Every surface, from a single room to a whole site.</h2>
      </div>
      <p>Homes, offices, care homes and exhibition stands. Interior or exterior, we prep carefully and finish cleanly.</p>
    </div>
    <div class="chart">
      <div class="row rv"><div class="chip" style="--c:#E9DCC3">Interior<br>LB-01</div><h3><svg class="ic"><use href="#i-roller"/></svg>Interior</h3><p>Walls, ceilings, doors and woodwork, brought up sharp with a durable finish.</p></div>
      <div class="row rv" style="--d:.04s"><div class="chip lt" style="--c:#4C6B5A">Exterior<br>LB-02</div><h3><svg class="ic"><use href="#i-wall"/></svg>Exterior</h3><p>Masonry, windows, fascias and front doors painted to stand up to the weather.</p></div>
      <div class="row rv" style="--d:.08s"><div class="chip lt" style="--c:#2F4A6B">Domestic<br>LB-03</div><h3><svg class="ic"><use href="#i-house"/></svg>Domestic and residential</h3><p>Houses, flats and single rooms. Tidy, careful work in a home you live in.</p></div>
      <div class="row rv" style="--d:.12s"><div class="chip" style="--c:#FFC712">Commercial<br>LB-04</div><h3><svg class="ic"><use href="#i-building"/></svg>Commercial</h3><p>Offices, shops and units decorated to a professional standard and a set timeline.</p></div>
      <div class="row rv" style="--d:.16s"><div class="chip" style="--c:#D9A7A0">Care homes<br>LB-05</div><h3><svg class="ic"><use href="#i-heart"/></svg>Care homes</h3><p>Considerate decorating in occupied settings, with calm colours and clean working.</p></div>
      <div class="row rv" style="--d:.2s"><div class="chip lt" style="--c:#8A3B2C">Exhibition<br>LB-06</div><h3><svg class="ic"><use href="#i-presentation"/></svg>Exhibition work</h3><p>Stands and display walls finished to a high spec and ready on the day.</p></div>
      <div class="row rv" style="--d:.24s"><div class="chip lt" style="--c:#3A3A3A">Tenancy<br>LB-07</div><h3><svg class="ic"><use href="#i-sparkles"/></svg>End of tenancy deep cleans and refreshes</h3><p>A deep clean and fresh coat so the property is ready to hand back or re-let.</p></div>
    </div>
  </div>
</section>

<section id="gallery">
  <div class="wrap">
    <div class="intro rv">
      <div>
        <p class="eyebrow"><svg class="ic"><use href="#i-camera"/></svg>Recent work</p>
        <h2 class="lede">Fresh from the brush, around the North West.</h2>
      </div>
      <p>A look at some recent jobs. Tap any photo to open it full size.</p>
    </div>
    <div class="gal" id="gal">
      <button class="gal-item rv" type="button" style="--d:.02s" data-src="images/recent-work1.jpg" aria-label="View recent work photo 1">
        <img src="images/recent-work1.jpg" alt="Recent painting and decorating work by LB Painters" loading="lazy" decoding="async">
        <span class="gal-ov" aria-hidden="true"><svg class="ic"><use href="#i-expand"/></svg></span>
      </button>
      <button class="gal-item rv" type="button" style="--d:.08s" data-src="images/recent-work2.jpg" aria-label="View recent work photo 2">
        <img src="images/recent-work2.jpg" alt="Recent painting and decorating work by LB Painters" loading="lazy" decoding="async">
        <span class="gal-ov" aria-hidden="true"><svg class="ic"><use href="#i-expand"/></svg></span>
      </button>
      <button class="gal-item rv" type="button" style="--d:.14s" data-src="images/recent%20work%203.jpg" aria-label="View recent work photo 3">
        <img src="images/recent%20work%203.jpg" alt="Recent painting and decorating work by LB Painters" loading="lazy" decoding="async">
        <span class="gal-ov" aria-hidden="true"><svg class="ic"><use href="#i-expand"/></svg></span>
      </button>
      <button class="gal-item rv" type="button" style="--d:.2s" data-src="images/recent%20work%204.jpg" aria-label="View recent work photo 4">
        <img src="images/recent%20work%204.jpg" alt="Recent painting and decorating work by LB Painters" loading="lazy" decoding="async">
        <span class="gal-ov" aria-hidden="true"><svg class="ic"><use href="#i-expand"/></svg></span>
      </button>
      <button class="gal-item rv" type="button" style="--d:.02s" data-src="images/recent%20work%206.jpg" aria-label="View recent work photo 5">
        <img src="images/recent%20work%206.jpg" alt="Recent painting and decorating work by LB Painters" loading="lazy" decoding="async">
        <span class="gal-ov" aria-hidden="true"><svg class="ic"><use href="#i-expand"/></svg></span>
      </button>
      <button class="gal-item rv" type="button" style="--d:.08s" data-src="images/recent%20work%208.jpg" aria-label="View recent work photo 6">
        <img src="images/recent%20work%208.jpg" alt="Recent painting and decorating work by LB Painters" loading="lazy" decoding="async">
        <span class="gal-ov" aria-hidden="true"><svg class="ic"><use href="#i-expand"/></svg></span>
      </button>
      <button class="gal-item rv" type="button" style="--d:.14s" data-src="images/recent%20work%2010.jpg" aria-label="View recent work photo 7">
        <img src="images/recent%20work%2010.jpg" alt="Recent painting and decorating work by LB Painters" loading="lazy" decoding="async">
        <span class="gal-ov" aria-hidden="true"><svg class="ic"><use href="#i-expand"/></svg></span>
      </button>
      <button class="gal-item rv" type="button" style="--d:.2s" data-src="images/recent%20work%2011.jpg" aria-label="View recent work photo 8">
        <img src="images/recent%20work%2011.jpg" alt="Recent painting and decorating work by LB Painters" loading="lazy" decoding="async">
        <span class="gal-ov" aria-hidden="true"><svg class="ic"><use href="#i-expand"/></svg></span>
      </button>
    </div>
  </div>
</section>

<section id="about">
  <div class="wrap about-grid">
    <div class="about-media rv-l">
      <div class="about-frame">
        <img src="images/About%20lb%20painters.jpg" alt="The LB Painters sign at Hill Top Farm" loading="lazy" decoding="async">
      </div>
      <span class="about-badge"><svg class="ic"><use href="#i-shield"/></svg>Fully insured</span>
    </div>
    <div class="about-copy rv" style="--d:.1s">
      <p class="eyebrow"><svg class="ic"><use href="#i-users"/></svg>About us</p>
      <h2 class="lede">Local painters who treat every wall like their own.</h2>
      <p class="lead" style="margin-top:22px">LB Painters is a professional painting and decorating company based in Cheadle Hulme, working across Manchester, Stockport, Cheshire and beyond. From a single room to a whole commercial site, every job gets the same care: proper preparation, a premium finish and a tidy handover.</p>
      <p class="lead">We work in lived-in homes, busy offices and occupied care homes, so we plan around you, dust sheets down, furniture protected, and everything left clean at the end of the day.</p>
      <ul class="ticks">
        <li><svg class="ic"><use href="#i-check-circle"/></svg><span>Fully insured for every job</span></li>
        <li><svg class="ic"><use href="#i-check-circle"/></svg><span>Five-star rated on Facebook</span></li>
        <li><svg class="ic"><use href="#i-check-circle"/></svg><span>Premium paints, bespoke finishes</span></li>
        <li><svg class="ic"><use href="#i-check-circle"/></svg><span>Tidy, respectful and on schedule</span></li>
      </ul>
      <div class="about-cta">
        <a class="btn solid" href="#contact">Get a quote <svg class="ic"><use href="#i-arrow-right"/></svg></a>
        <a class="btn" href="tel:+447576668083"><svg class="ic"><use href="#i-phone"/></svg>07576 668083</a>
      </div>
    </div>
  </div>
</section>

<section class="tester" id="colour">
  <div class="wrap">
    <p class="eyebrow"><svg class="ic"><use href="#i-palette"/></svg>Colour preview</p>
    <h2 class="lede">Not sure on the colour? Try it on the wall.</h2>
    <div class="room">
      <svg class="rv-s" viewBox="0 0 600 400" role="img" aria-label="Illustration of a room whose wall colour changes when you pick a swatch">
        <rect id="wall" width="600" height="300" fill="#E9DCC3"/>
        <rect y="300" width="600" height="100" fill="#8b6f4e"/>
        <rect y="288" width="600" height="14" fill="#f4f2ec"/>
        <rect x="70" y="50" width="170" height="170" fill="#f4f2ec"/><rect x="82" y="62" width="146" height="146" fill="#bcd3e0"/><rect x="152" y="62" width="6" height="146" fill="#f4f2ec"/><rect x="82" y="130" width="146" height="6" fill="#f4f2ec"/>
        <rect x="330" y="70" width="90" height="120" fill="#f4f2ec"/><rect x="340" y="80" width="70" height="100" fill="#0c0c0c" opacity=".85"/>
        <rect x="300" y="215" width="270" height="85" rx="14" fill="#2a2a2a"/><rect x="300" y="185" width="270" height="50" rx="14" fill="#3a3a3a"/>
        <rect x="90" y="330" width="220" height="14" fill="#0c0c0c" opacity=".12"/>
      </svg>
      <div class="rv" style="--d:.12s">
        <p class="pick" id="pick" aria-live="polite"><svg class="ic"><use href="#i-palette"/></svg><span>Chalk</span></p>
        <div class="sw" id="sw" role="group" aria-label="Wall colours"></div>
        <small>Have a shade or brand in mind? Tell us and we'll quote to match it.</small>
      </div>
    </div>
  </div>
</section>

<div class="band">
  <div class="wrap">
    <div class="rv"><svg class="ic"><use href="#i-shield"/></svg>Fully insured<span>Cover in place for every job, domestic or commercial.</span></div>
    <div class="rv" style="--d:.1s"><span class="stars" aria-label="Five stars"><svg class="ic"><use href="#i-star"/></svg><svg class="ic"><use href="#i-star"/></svg><svg class="ic"><use href="#i-star"/></svg><svg class="ic"><use href="#i-star"/></svg><svg class="ic"><use href="#i-star"/></svg></span>Five-star rated<span>Recommended by customers on Facebook. <a href="#reviews">Read the reviews</a></span></div>
    <div class="rv" style="--d:.2s"><svg class="ic"><use href="#i-sparkles"/></svg>Bespoke finishes<span>Premium results, chosen and applied with care.</span></div>
  </div>
</div>

<section id="reviews">
  <div class="wrap">
    <div class="intro rv">
      <div>
        <p class="eyebrow"><svg class="ic"><use href="#i-quote"/></svg>Reviews</p>
        <h2 class="lede">The work speaks. So do the people who booked it.</h2>
      </div>
      <p>Homeowners, landlords and site managers across Manchester and Cheshire. Proper preparation, a clean finish, and the job left tidy.</p>
    </div>

    <div class="rev-sum rv" style="--d:.08s">
      <span class="rev-score">5.0<small>/ 5</small></span>
      <span class="stars" role="img" aria-label="Rated 5 out of 5"><svg class="ic" aria-hidden="true"><use href="#i-star"/></svg><svg class="ic" aria-hidden="true"><use href="#i-star"/></svg><svg class="ic" aria-hidden="true"><use href="#i-star"/></svg><svg class="ic" aria-hidden="true"><use href="#i-star"/></svg><svg class="ic" aria-hidden="true"><use href="#i-star"/></svg></span>
      <p>Recommended by customers on Facebook, and by word of mouth across the North West.</p>
      <a class="rev-src" href="https://web.facebook.com/LBPainters5/" rel="noopener"><svg class="ic" aria-hidden="true"><use href="#i-facebook"/></svg>Read them on Facebook</a>
    </div>

    <div class="rev-wall">
      <figure class="rev-feat rv-l">
        <svg class="ic rev-mark" aria-hidden="true"><use href="#i-quote"/></svg>
        <blockquote><?= htmlspecialchars($reviews[0]['text']) ?></blockquote>
        <figcaption class="rev-who">
          <span class="rev-av" aria-hidden="true"><svg class="ic"><use href="#<?= $reviews[0]['ico'] ?>"/></svg></span>
          <strong><?= htmlspecialchars($reviews[0]['who']) ?></strong>
          <span class="rev-town"><?= htmlspecialchars($reviews[0]['town']) ?></span>
          <span class="rev-tag"><svg class="ic" aria-hidden="true"><use href="#i-star"/></svg>5.0</span>
        </figcaption>
      </figure>

      <ul class="rev-list">
        <?php foreach (array_slice($reviews, 1) as $i => $r): ?>
        <li class="rv" style="--d:<?= round(0.06 + $i * 0.06, 2) ?>s">
          <blockquote><?= htmlspecialchars($r['text']) ?></blockquote>
          <p class="rev-who">
            <span class="rev-av" aria-hidden="true"><svg class="ic"><use href="#<?= $r['ico'] ?>"/></svg></span>
            <strong><?= htmlspecialchars($r['who']) ?></strong>
            <span class="rev-town"><?= htmlspecialchars($r['town']) ?></span>
            <span class="rev-tag"><svg class="ic" aria-hidden="true"><use href="#i-star"/></svg>5.0</span>
          </p>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<section id="areas">
  <div class="wrap">
    <p class="eyebrow rv"><svg class="ic"><use href="#i-pin"/></svg>Coverage</p>
    <h2 class="lede rv">Based in Cheadle Hulme.</h2>
    <p class="areas rv" style="--d:.1s"><span class="town">Didsbury</span>, <span class="town">Manchester</span>, <span class="town">Altrincham</span>, <span class="town">Cheadle Hulme</span>, <span class="town">Wilmslow</span>, <span class="town">Alderley Edge</span>, <span class="town">Stockport</span> <i>and across Cheshire East.</i></p>
  </div>
</section>

<section class="contact" id="contact">
  <div class="wrap cols">
    <div class="rv-l">
      <p class="eyebrow"><svg class="ic"><use href="#i-message"/></svg>Get in touch</p>
      <h2 class="lede">Tell us what needs painting.</h2>
      <a class="big" href="tel:+447576668083"><svg class="ic"><use href="#i-phone"/></svg><span>07576 668083</span></a>
      <a class="big" href="mailto:lbpainters@outlook.com"><svg class="ic"><use href="#i-mail"/></svg><span>lbpainters@outlook.com</span></a>
    </div>
    <form class="rv" id="f" method="post" action="#contact" style="--d:.12s">
      <?php if ($status === 'ok'): ?><p class="note ok" role="status"><svg class="ic"><use href="#i-check-circle"/></svg>Thanks, your enquiry has been sent. We'll be in touch soon.</p>
      <?php elseif ($status === 'missing'): ?><p class="note bad" role="alert">Please add your name and a phone number or email.</p>
      <?php elseif ($status === 'fail'): ?><p class="note bad" role="alert">Sorry, that didn't send. Please call 07576 668083 or email lbpainters@outlook.com.</p><?php endif; ?>
      <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px">
      <label><span class="lbl"><svg class="ic"><use href="#i-user"/></svg>Your name</span><input name="n" required autocomplete="name" value="<?= $status === 'missing' ? htmlspecialchars($clean($_POST['n'] ?? '')) : '' ?>"></label>
      <label><span class="lbl"><svg class="ic"><use href="#i-phone"/></svg>Phone number</span><input name="p" type="tel" autocomplete="tel"></label>
      <label><span class="lbl"><svg class="ic"><use href="#i-at"/></svg>Email (optional if you add a phone number)</span><input name="e" type="email" autocomplete="email"></label>
      <label><span class="lbl"><svg class="ic"><use href="#i-clipboard"/></svg>Type of job</span>
        <select name="t"><option>Interior</option><option>Exterior</option><option>Commercial</option><option>Care home</option><option>Exhibition work</option><option>End of tenancy</option><option>Something else</option></select>
      </label>
      <label><span class="lbl"><svg class="ic"><use href="#i-message"/></svg>Details</span><textarea name="m" placeholder="Rooms, area, timing, colours"></textarea></label>
      <button class="btn solid" type="submit">Send enquiry <svg class="ic"><use href="#i-send"/></svg></button>
    </form>
  </div>
</section>

<footer>
  <div class="wrap fwrap">
    <div class="fbrand">
      <img class="flogo" src="images/logo.png" alt="LB Painters &mdash; professional painting services" width="170" height="170">
      <small>Professional Painter &amp; Decorator, Cheadle Hulme. Serving Manchester, Stockport and Cheshire.</small>
    </div>
    <nav class="fnav" aria-label="Footer">
      <a href="#work"><svg class="ic"><use href="#i-roller"/></svg>What we paint</a>
      <a href="#gallery"><svg class="ic"><use href="#i-camera"/></svg>Recent work</a>
      <a href="#about"><svg class="ic"><use href="#i-users"/></svg>About us</a>
      <a href="#reviews"><svg class="ic"><use href="#i-quote"/></svg>Reviews</a>
      <a href="#areas"><svg class="ic"><use href="#i-pin"/></svg>Areas we cover</a>
    </nav>
    <div class="fsoc">
      <a href="tel:+447576668083"><svg class="ic"><use href="#i-phone"/></svg>07576 668083</a>
      <a href="mailto:lbpainters@outlook.com"><svg class="ic"><use href="#i-mail"/></svg>lbpainters@outlook.com</a>
      <a class="fb" href="https://web.facebook.com/LBPainters5/" rel="noopener"><svg class="ic"><use href="#i-facebook"/></svg>Follow on Facebook</a>
    </div>
  </div>
  <div class="wrap fbot">
    <span>&copy; <?= date('Y') ?> LB Painters. All rights reserved.</span>
    <a href="#top"><svg class="ic"><use href="#i-arrow-up"/></svg>Back to top</a>
  </div>
</footer>

<button class="totop" id="totop" type="button" aria-label="Back to top"><svg class="ic"><use href="#i-arrow-up"/></svg></button>

<div class="lb" id="lb" role="dialog" aria-modal="true" aria-label="Photo viewer" aria-hidden="true">
  <button class="lb-btn x" id="lbClose" type="button" aria-label="Close viewer"><svg class="ic"><use href="#i-close"/></svg></button>
  <button class="lb-btn prev" id="lbPrev" type="button" aria-label="Previous photo"><svg class="ic"><use href="#i-chev-left"/></svg></button>
  <img id="lbImg" src="" alt="">
  <button class="lb-btn next" id="lbNext" type="button" aria-label="Next photo"><svg class="ic"><use href="#i-chev-right"/></svg></button>
  <p class="lb-cap" id="lbCap"></p>
</div>

<script>
const reduce = matchMedia('(prefers-reduced-motion: reduce)').matches;

/* Colour tester */
const cols=[["Chalk","#E9DCC3"],["Sage","#7C9A86"],["Harbour blue","#2F4A6B"],["Clay","#B5654A"],["Mustard","#FFC712"],["Blush","#E3B8B0"],["Slate","#5A6470"],["Charcoal","#2B2B2B"]];
const sw=document.getElementById('sw'),wall=document.getElementById('wall'),pick=document.getElementById('pick'),pickName=pick.querySelector('span');
cols.forEach(([n,c],i)=>{
  const b=document.createElement('button');
  b.type='button';b.style.setProperty('--c',c);b.setAttribute('aria-label',n);b.setAttribute('aria-pressed',i==0);
  b.innerHTML='<svg class="ic"><use href="#i-check"/></svg>';
  b.onclick=()=>{
    wall.setAttribute('fill',c);pickName.textContent=n;
    sw.querySelectorAll('button').forEach(x=>x.setAttribute('aria-pressed',x===b));
  };
  sw.appendChild(b);
});

/* Fade in / fade out on scroll */
const rvs=[...document.querySelectorAll('.rv,.rv-l,.rv-s')],
      showAll=()=>rvs.forEach(el=>el.classList.add('in')),
      inView=el=>{const r=el.getBoundingClientRect();return r.top<innerHeight*.92&&r.bottom>0;};
if('IntersectionObserver' in window){
  let fired=false;
  const io=new IntersectionObserver((es)=>{
    fired=true;
    es.forEach(e=>e.target.classList.toggle('in',e.isIntersecting));
  },{rootMargin:'0px 0px -10% 0px',threshold:.05});
  rvs.forEach(el=>io.observe(el));
  rvs.forEach(el=>{if(inView(el))el.classList.add('in');});
  setTimeout(()=>{if(!fired)showAll();},2500);
}else{
  showAll();
}

/* Hero film: autoplay + loop, always, from page load. Playback is deliberately
   NOT gated on prefers-reduced-motion / saveData - the visible pause button is
   the control for it (and the muted flag is what makes autoplay permitted).
   play() is re-issued on every lifecycle event a browser might use to stop it. */
const heroVideo=document.getElementById('heroVideo'),heroEl=document.getElementById('top'),reelBar=document.getElementById('reelBar'),vToggle=document.getElementById('vToggle');
if(heroVideo){
  let userPaused=false;
  const play=()=>{
    if(userPaused||document.hidden)return;
    heroVideo.muted=true;
    const p=heroVideo.play();
    if(p&&p.catch)p.catch(()=>{});
  };
  const mark=on=>{if(vToggle){vToggle.classList.toggle('is-paused',!on);vToggle.setAttribute('aria-label',on?'Pause background video':'Play background video');}};
  play();
  ['loadedmetadata','loadeddata','canplay','canplaythrough','playing','seeked'].forEach(ev=>heroVideo.addEventListener(ev,play));
  heroVideo.addEventListener('ended',()=>{try{heroVideo.currentTime=0;}catch(e){}play();});
  addEventListener('load',play);
  addEventListener('pageshow',play);
  ['pointerdown','keydown','touchstart','scroll'].forEach(ev=>addEventListener(ev,play,{once:true,passive:true}));
  document.addEventListener('visibilitychange',()=>{if(document.hidden)heroVideo.pause();else play();});
  heroVideo.addEventListener('timeupdate',()=>{
    if(reelBar&&heroVideo.duration)reelBar.style.width=(heroVideo.currentTime/heroVideo.duration*100).toFixed(1)+'%';
  });
  heroVideo.addEventListener('play',()=>mark(true));
  heroVideo.addEventListener('pause',()=>mark(false));
  if(vToggle)vToggle.addEventListener('click',()=>{
    if(heroVideo.paused){userPaused=false;play();}
    else{userPaused=true;heroVideo.pause();}
  });
}

/* The wall paints itself, then hands over to the film */
if(heroEl){
  if(reduce)heroEl.classList.add('live');
  else{
    heroEl.classList.remove('live');
    setTimeout(()=>heroEl.classList.add('live'),1300);
  }
}

/* Scroll progress, sticky header, back to top, hero copy fade */
const bar=document.getElementById('progress'),topbar=document.getElementById('topbar'),
      totop=document.getElementById('totop'),heroCopy=document.querySelector('.hero-copy'),
      cueEl=document.querySelector('.cue');
let ticking=false;
function onScroll(){
  ticking=false;
  const y=window.scrollY,vh=innerHeight;
  const max=document.documentElement.scrollHeight-vh;
  bar.style.width=(max>0?(y/max)*100:0)+'%';
  topbar.classList.toggle('show',y>vh*.55);
  totop.classList.toggle('show',y>vh*.9);
  if(y<vh*1.3){
    const f=Math.min(1,Math.max(0,y/(vh*.85)));
    if(!reduce&&heroCopy){
      heroCopy.style.opacity=String(1-f);
      heroCopy.style.transform='translateY('+(f*26).toFixed(1)+'px)';
    }
    if(cueEl)cueEl.style.opacity=String(Math.max(0,1-y/(vh*.3)).toFixed(2));
  }
}
addEventListener('scroll',()=>{if(!ticking){ticking=true;requestAnimationFrame(onScroll);}},{passive:true});
addEventListener('resize',onScroll);
onScroll();
totop.addEventListener('click',()=>scrollTo({top:0,behavior:reduce?'auto':'smooth'}));

/* Mobile menu */
const mmenu=document.getElementById('mmenu'),burgers=document.querySelectorAll('.burger');
function setMenu(open){
  mmenu.classList.toggle('open',open);
  mmenu.setAttribute('aria-hidden',String(!open));
  document.body.classList.toggle('locked',open);
  burgers.forEach(b=>b.setAttribute('aria-expanded',String(open)));
}
burgers.forEach(b=>b.addEventListener('click',()=>setMenu(!mmenu.classList.contains('open'))));
mmenu.querySelector('.close').addEventListener('click',()=>setMenu(false));
mmenu.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>setMenu(false)));
addEventListener('keydown',e=>{if(e.key==='Escape'&&mmenu.classList.contains('open'))setMenu(false);});

/* Recent work lightbox */
const items=[...document.querySelectorAll('.gal-item')],
      lb=document.getElementById('lb'),lbImg=document.getElementById('lbImg'),
      lbCap=document.getElementById('lbCap'),lbClose=document.getElementById('lbClose');
let idx=0;
function openLb(i){
  idx=(i+items.length)%items.length;
  const el=items[idx];
  lbImg.src=el.dataset.src;
  lbImg.alt=el.querySelector('img').alt;
  lbCap.textContent=(idx+1)+' / '+items.length;
  lb.classList.add('open');
  lb.setAttribute('aria-hidden','false');
  document.body.classList.add('locked');
  lbClose.focus();
}
function closeLb(){
  lb.classList.remove('open');
  lb.setAttribute('aria-hidden','true');
  document.body.classList.remove('locked');
  if(items[idx])items[idx].focus();
}
items.forEach((el,i)=>el.addEventListener('click',()=>openLb(i)));
lbClose.addEventListener('click',closeLb);
document.getElementById('lbPrev').addEventListener('click',()=>openLb(idx-1));
document.getElementById('lbNext').addEventListener('click',()=>openLb(idx+1));
lb.addEventListener('click',e=>{if(e.target===lb)closeLb();});
addEventListener('keydown',e=>{
  if(!lb.classList.contains('open'))return;
  if(e.key==='Escape')closeLb();
  else if(e.key==='ArrowLeft')openLb(idx-1);
  else if(e.key==='ArrowRight')openLb(idx+1);
});
</script>
</body>
</html>