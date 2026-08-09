<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="margin:0; padding:0; background-color:#f4f4f7; font-family: Arial, Helvetica, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f7; padding: 32px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">

                    <tr>
                        <td style="background-color:#111827; padding: 24px 32px;">
                            <h1 style="margin:0; color:#ffffff; font-size: 18px;">EmporiO</h1>
                        </td>
                    </tr>


                    <tr>
                        <td style="padding: 32px;">
                            <h2 style="margin:0 0 16px; color:#111827; font-size: 20px;">Você recebeu uma nova mensagem</h2>
                            <p style="margin:0 0 24px; color:#4b5563; font-size: 14px;">Uma nova mensagem de contato foi enviada através do EmporiO.</p>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f9fafb; border-radius:6px; padding: 4px; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 8px 16px; font-size: 14px; color:#6b7280; width: 80px;">Nome</td>
                                    <td style="padding: 8px 16px; font-size: 14px; color:#111827; font-weight:bold;">{{ $fromName }}</td>
                                </tr>

                            </table>

                            <p style="margin:0 0 8px; font-size: 14px; color:#6b7280; font-weight:bold;">Mensagem</p>
                            <p style="margin:0; font-size: 14px; color:#111827; line-height: 1.6; white-space: pre-line;">{{ $fromMessage }}</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="background-color:#f9fafb; padding: 16px 32px; text-align:center; border-top: 1px solid #e5e7eb;">
                            <p style="margin:0; font-size: 12px; color:#9ca3af;">Este é um e-mail automático do sistema EmporiO. Não é necessário responder.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>