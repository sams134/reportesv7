<div class="terms-header">
    <table class="terms-logo-table">
        <tr>
            <td class="terms-logo-cme-cell">
                @if(file_exists($logoPath))
                    <img src="{{ $logoPath }}" class="terms-logo-cme" alt="CME">
                @endif

                <div class="terms-slogan-box">
                    Soluciones Electromecánicas de alta confiabilidad
                </div>
            </td>

            <td class="terms-logo-certificaciones-cell">
                @if(file_exists($wegPath))
                    <img src="{{ $wegPath }}" class="terms-logo-weg" alt="WEG">
                @endif

                @if(file_exists($easaPath))
                    <img src="{{ $easaPath }}" class="terms-logo-easa" alt="EASA">
                @endif
            </td>
        </tr>
    </table>

    <div class="terms-document-title">
        Términos y condiciones de cotización, reparación y garantía
    </div>
</div>