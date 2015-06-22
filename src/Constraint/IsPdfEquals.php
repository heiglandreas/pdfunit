<?php
/**
 * Copyright (c)2015-2015 heiglandreas
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIBILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category
 * @author    Andreas Heigl<andreas@heigl.org>
 * @copyright ©2015-2015 Andreas Heigl
 * @license   http://www.opesource.org/licenses/mit-license.php MIT-License
 * @version   0.0
 * @since     17.06.15
 * @link      https://github.com/heiglandreas/
 */

namespace Org_Heigl\PDFUnit\Constraint;

class IsPdfEquals extends \PHPUnit_Framework_Constraint
{

    protected $comparisonFile;

    protected $threshold = 0.5;

    public function __construct($comparison, $threshold)
    {
        if (! file_Exists($comparison)) {
            throw new \Exception(sprintf(
                'No file "%s" found',
                $comparison
            ));
        }

        $this->threshold      = $threshold;
        $this->comparisonFile = $comparison;
    }
    /**
     * Evaluates the constraint for parameter $other. Returns TRUE if the
     * constraint is met, FALSE otherwise.
     *
     * @param mixed $other Value or object to evaluate.
     * @return bool
     */
    public function matches($other)
    {
        if (! file_exists($other)) {
            throw new \Exception(sprintf(
                'There has been no file to compare'
            ));

        }
        $command = sprintf(
            'compare -metric mae %s %s %s 2>&1',
            escapeshellarg($this->comparisonFile),
            escapeshellarg($other),
            escapeshellarg(tempnam(sys_get_temp_dir(), 'compass_test_diff'))
        );

        exec($command, $result, $retVal);

        if ($retVal > 1) {
            throw new \Exception(sprintf(
                'There has been an error in executing the compare-script'
            ));
        }

        if (! preg_match('/[\d\.]+\s+\(([\d\.]+)\)/', $result[0], $regMatch)) {
            throw new \Exception(sprintf(
                'The result has not been parseable'
            ));
        }

        return (float)$regMatch[1] <= $this->threshold;
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string
     */
    public function toString()
    {
        return sprintf(
            'differs not more than %s from "%s"',
            $this->threshold,
            basename($this->comparisonFile)
        );
    }

    /**
     * Returns the description of the failure
     *
     * The beginning of failure messages is "Failed asserting that" in most
     * cases. This method should return the second part of that sentence.
     *
     * @param  mixed  $other Evaluated value or object.
     * @return string
     */
    protected function failureDescription($other)
    {
        return sprintf(
            'the created PDF-File differs less than %s from "%s"',
            $this->threshold,
            basename($this->comparisonFile)
        );
    }


}