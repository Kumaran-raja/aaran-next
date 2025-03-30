### **📌 How to Use the `settings` Column in the `tenants` Table?**

The `settings` column in the `tenants` table is a JSON field that can store **configurable options** for each tenant without needing additional columns. This allows flexibility and customization for different businesses.

---

## **🔹 What Can We Store in `settings`?**

### **1️⃣ UI & Theme Settings**
- `theme` → Dark mode, light mode, custom theme colors.
- `logo` → Path to tenant’s logo.
- `timezone` → Business-specific timezone.
- `language` → Default language selection.

**Example:**
   ```json
   {
       "theme": "dark",
       "logo": "/storage/logos/tenant1.png",
       "timezone": "Asia/Kolkata",
       "language": "en"
   }
   ```

---

### **2️⃣ Business Preferences**
- `currency` → Preferred currency (`INR`, `USD`, etc.).
- `date_format` → Date display format.
- `time_format` → `12h` or `24h`.
- `tax_included` → Boolean (`true` / `false`).
- `invoice_prefix` → Custom invoice numbering format.

**Example:**
   ```json
   {
       "currency": "INR",
       "date_format": "d/m/Y",
       "time_format": "24h",
       "tax_included": true,
       "invoice_prefix": "INV-"
   }
   ```

---

### **3️⃣ Notification & Communication Settings**
- `email_notifications` → Enable/disable emails.
- `sms_notifications` → Enable/disable SMS.
- `whatsapp_notifications` → Enable/disable WhatsApp messages.
- `preferred_contact_method` → `email`, `sms`, `whatsapp`.

**Example:**
   ```json
   {
       "email_notifications": true,
       "sms_notifications": false,
       "whatsapp_notifications": true,
       "preferred_contact_method": "whatsapp"
   }
   ```

---

### **4️⃣ Access & Security Settings**
- `two_factor_enabled` → Boolean.
- `ip_restriction` → Allow login only from specific IPs.
- `allowed_devices` → Limit login to specific devices.

**Example:**
   ```json
   {
       "two_factor_enabled": true,
       "ip_restriction": ["192.168.1.1", "203.0.113.45"],
       "allowed_devices": ["desktop", "mobile"]
   }
   ```

---

### **5️⃣ Integration & API Keys**
- `payment_gateway` → Stripe, PayPal, Razorpay.
- `api_keys` → Store API keys for third-party services.
- `webhooks` → URLs for webhook notifications.

**Example:**
   ```json
   {
       "payment_gateway": "stripe",
       "api_keys": {
           "stripe": "sk_live_123456",
           "razorpay": "rzp_live_abcdef"
       },
       "webhooks": {
           "order_created": "https://example.com/webhook/order",
           "payment_received": "https://example.com/webhook/payment"
       }
   }
   ```

---

## **🔹 How to Use `settings` in Code?**
### **✅ Get a Setting Value**
```php
$tenant = Auth::user()->tenant;
$timezone = $tenant->settings['timezone'] ?? 'UTC';
```

### **✅ Update a Setting**
```php
$tenant->update([
    'settings' => array_merge($tenant->settings ?? [], ['theme' => 'light'])
]);
```

### **✅ Check a Setting**
```php
if (($tenant->settings['two_factor_enabled'] ?? false) === true) {
    // Force 2FA
}
```

---

## **🚀 Benefits of Using `settings` JSON Column**
✔ **Highly Flexible** → No need to add new columns for every new setting.  
✔ **Easy Customization** → Each tenant can have unique settings.  
✔ **Improved Performance** → One JSON column instead of multiple table joins.  
✔ **Future-Proof** → Easily add new settings without modifying the schema.

---

## **✨ Final Thoughts**
- The `settings` column is **perfect for storing per-tenant preferences** without bloating the database.
- It can be used for UI themes, business configurations, security, integrations, and more.
- Laravel makes it easy to **retrieve, update, and check JSON settings** using Eloquent.

🚀 **Now, your tenants can have personalized experiences based on their settings!** 🚀


### **📌 Difference Between `settings` and `features` in the Tenant Table**

| **Aspect**        | **Settings (`settings` Column)**                                      | **Features (`enabled_features` Column)**                       |
|------------------|-------------------------------------------------------------------------|----------------------------------------------------------------|
| **Definition**   | Stores tenant-specific configurations and preferences.                 | Stores the list of enabled/disabled features for the tenant.  |
| **Purpose**     | Controls UI, business rules, security, integrations, etc.               | Controls what functionality is available for the tenant.       |
| **Data Type**   | JSON (key-value pairs).                                                 | JSON (array of feature codes).                                 |
| **Usage**       | Customization for each tenant (e.g., currency, theme, notifications).   | Determines which features/modules are available.               |
| **Changes**     | Frequently modified by the tenant (e.g., changing themes, API keys).    | Typically modified by an admin when enabling/disabling features. |
| **Example Data** | `{ "theme": "dark", "timezone": "Asia/Kolkata", "tax_included": true }` | `["custom_reports", "multi_currency", "inventory_tracking"]`   |
| **Where Used?** | UI settings, configurations, user preferences.                         | Module activation, feature flags, tenant-based functionality.  |

---

## **📌 When to Use Each?**
✅ **Use `settings` for:**
- Business preferences (currency, tax settings, timezone).
- UI customization (theme, layout, language).
- Security settings (2FA, allowed IPs).
- Integration settings (API keys, webhooks, third-party services).

✅ **Use `features` for:**
- Enabling/disabling modules (invoicing, CRM, inventory, payroll).
- Restricting access to specific functionalities.
- Feature-based subscription plans (Basic vs. Pro).
- Industry-based feature segregation.

---

## **📌 Example Scenario**
A tenant **runs an e-commerce business** and subscribes to a **Basic Plan**.

### **🔹 `settings` Example:**
```json
{
    "currency": "USD",
    "timezone": "America/New_York",
    "theme": "dark",
    "email_notifications": true
}
```
- This controls **how the app behaves** for this tenant.

### **🔹 `features` Example:**
```json
[
    "basic_invoicing",
    "multi_currency",
    "order_tracking"
]
```
- This controls **which features are available** to this tenant.

---

## **🚀 Summary**
🔹 **`settings` = Configurations & preferences** → **How things work**  
🔹 **`features` = Functionalities & modules** → **What is available**

🚀 **Both work together to create a customized experience for each tenant!** 🚀
