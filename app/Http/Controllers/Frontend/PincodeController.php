<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PincodeController extends Controller
{
    public function lookup(Request $request): JsonResponse
    {
        $pincode = trim((string) $request->query('pincode', $request->input('pincode', '')));

        if (!preg_match('/^\d{6}$/', $pincode)) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid 6-digit pincode.',
            ], 422);
        }

        $index = $this->loadIndex();

        if (!isset($index[$pincode])) {
            return response()->json([
                'success' => false,
                'message' => 'No state/district found for this pincode.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'pincode' => $pincode,
            'state' => $index[$pincode]['state'],
            'district' => $index[$pincode]['district'],
            'country' => 'India',
        ]);
    }

    /**
     * Load (and build on first use) the pincode → {state, district} index.
     * Source: public/pincodeData.json (~20MB, contains duplicates).
     * Cached: storage/app/pincode_index.json (de-duplicated).
     */
    private function loadIndex(): array
    {
        $indexPath = storage_path('app/pincode_index.json');
        $sourcePath = public_path('pincodeData.json');

        if (!file_exists($indexPath) || (file_exists($sourcePath) && filemtime($sourcePath) > filemtime($indexPath))) {
            $this->buildIndex($sourcePath, $indexPath);
        }

        $raw = @file_get_contents($indexPath);
        if ($raw === false) {
            return [];
        }
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    private function buildIndex(string $sourcePath, string $indexPath): void
    {
        if (!file_exists($sourcePath)) {
            file_put_contents($indexPath, '{}');
            return;
        }

        $raw = file_get_contents($sourcePath);
        $data = json_decode($raw, true);
        $rows = $data['PincodeData']['pincodes'] ?? [];

        $index = [];
        foreach ($rows as $row) {
            $pin = isset($row['Pincode']) ? trim((string) $row['Pincode']) : '';
            if ($pin === '' || isset($index[$pin])) {
                continue;
            }
            $state = '';
            foreach ($row as $key => $value) {
                if (trim($key) === 'StateName') {
                    $state = trim((string) $value);
                    break;
                }
            }
            $district = isset($row['District']) ? trim((string) $row['District']) : '';

            $index[$pin] = [
                'state' => $this->titleCase($state),
                'district' => $this->titleCase($district),
            ];
        }

        $dir = dirname($indexPath);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        file_put_contents($indexPath, json_encode($index, JSON_UNESCAPED_UNICODE));
    }

    private function titleCase(string $value): string
    {
        if ($value === '') return '';
        return mb_convert_case(mb_strtolower($value, 'UTF-8'), MB_CASE_TITLE, 'UTF-8');
    }
}
