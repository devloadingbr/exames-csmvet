<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

/**
 * Security Headers Middleware
 * Implements Content Security Policy and other security headers
 */
class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Don't apply headers to API routes or non-HTML responses
        if ($request->is('api/*') || !$this->isHtmlResponse($response)) {
            return $response;
        }

        $this->applySecurityHeaders($response);
        $this->applyContentSecurityPolicy($response);

        return $response;
    }

    /**
     * Apply basic security headers
     */
    protected function applySecurityHeaders(Response|RedirectResponse $response): void
    {
        $headers = config('csp.additional_headers', []);

        foreach ($headers as $header => $value) {
            $response->headers->set($header, $value);
        }
    }

    /**
     * Apply Content Security Policy header
     */
    protected function applyContentSecurityPolicy(Response|RedirectResponse $response): void
    {
        $cspConfig = config('csp');
        $environment = app()->environment();
        
        // Merge environment-specific overrides
        if (isset($cspConfig[$environment])) {
            foreach ($cspConfig[$environment] as $directive => $sources) {
                if ($directive === 'upgrade-insecure-requests' && $sources === true) {
                    continue; // Handle this separately
                }
                $cspConfig[$directive] = array_merge(
                    $cspConfig[$directive] ?? [],
                    $sources
                );
            }
        }

        $csp = $this->buildCspHeader($cspConfig, $environment);
        
        if (!empty($csp)) {
            $response->headers->set('Content-Security-Policy', $csp);
        }
    }

    /**
     * Build CSP header string from configuration
     */
    protected function buildCspHeader(array $config, string $environment): string
    {
        $directives = [];

        // Standard CSP directives
        $standardDirectives = [
            'default-src',
            'script-src',
            'style-src',
            'font-src',
            'img-src',
            'connect-src',
            'media-src',
            'object-src',
            'frame-src',
            'frame-ancestors',
            'base-uri',
            'form-action',
        ];

        foreach ($standardDirectives as $directive) {
            if (!empty($config[$directive])) {
                $sources = is_array($config[$directive]) 
                    ? implode(' ', $config[$directive])
                    : $config[$directive];
                    
                $directives[] = "{$directive} {$sources}";
            }
        }

        // Add upgrade-insecure-requests for production
        if ($environment === 'production' && !empty($config['production']['upgrade-insecure-requests'])) {
            $directives[] = 'upgrade-insecure-requests';
        }

        // Add report directives
        if (!empty($config['report-uri'])) {
            $directives[] = "report-uri {$config['report-uri']}";
        }

        if (!empty($config['report-to'])) {
            $directives[] = "report-to {$config['report-to']}";
        }

        return implode('; ', $directives);
    }

    /**
     * Check if response is HTML
     */
    protected function isHtmlResponse(Response|RedirectResponse $response): bool
    {
        // Redirect responses should not have security headers applied
        if ($response instanceof RedirectResponse) {
            return false;
        }
        
        $contentType = $response->headers->get('content-type', '');
        return str_contains($contentType, 'text/html') || empty($contentType);
    }
}