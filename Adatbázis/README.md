# Insomnia végteszt – munkaruhaRaktar API

### Seedelt belépési adatok (gyors teszthez)
Ha lefuttattad a seedelést, akkor ezek a felhasználók léteznek:
- Super admin: `superadmin@example.com` / jelszó: `password`
- Admin: `admin@example.com` / jelszó: `password`
- User: `user@example.com` / jelszó: `password`


## 1) 3 db login (tokenek megszerzése)

### 1.1) User login
- Végpont: `POST /api/login`
- Body:
  - `{ "email": "user@example.com", "password": "password" }`
- Várható: 200, és kapsz `data.access_token`-t

### 1.2) Admin login
- Végpont: `POST /api/login`
- Body:
  - `{ "email": "admin@example.com", "password": "password" }`

### 1.3) Super admin login
- Végpont: `POST /api/login`
- Body:
  - `{ "email": "superadmin@example.com", "password": "password" }`

## 2) Profil végpontok tesztje (TOKEN_USER-rel is ok)

### 2.1) Saját profil lekérése
- Végpont: `GET /api/profile`
- Body: nincs
- Header: `Authorization: Bearer TOKEN_USER`
- Várható: 200, `data` tartalmazza a usert és a `profile`-t

### 2.2) Saját profil frissítése
- Végpont: `PUT /api/profile`
- Body: csak amit módosítasz (a `name` NEM küldhető)
  - Példa: `{ "city": "Szeged", "address": "Teszt utca 1" }`
- Várható: 200

### 2.3) Saját jelszó módosítása
- Végpont: `PUT /api/profile/password`
- Body:
  - `{ "password": "Aa1!aa!!", "password_confirmation": "Aa1!aa!!" }`
- Várható: 200

**Gyors ellenőrzés:**
- próbálj belépni a régi jelszóval → 401
- próbálj belépni az új jelszóval → 200

## 3) User jogosultság teszt (TOKEN_USER)

### 3.1) Termékek listázása (usernek ez az "egy" domain lista)
- Végpont: `GET /api/products`
- Body: nincs
- Várható: 200
- `category` és `location` mező (user elől rejtve van)

### 3.2) Termék megtekintése
- Végpont: `GET /api/products/{id}`
- Body: nincs
- Várható: 200

### 3.3) Tiltott műveletek usernek
Ezeknek 403-at kell adniuk:
- `POST /api/products`
- `PUT /api/products/{id}`
- `DELETE /api/products/{id}`
- `GET /api/categories`
- `GET /api/locations`

## 4) Admin teszt (TOKEN_ADMIN)

Admin tudjon CRUD-olni (de törölni nem).

### 4.1) Category létrehozás
- `POST /api/categories`
- Body:
  - `{ "name": "Felső", "description": "Opcionális" }`
- Várható: 200
- Mentsd el a kapott kategória `id`-ját: `CATEGORY_ID`

### 4.2) Location létrehozás
- `POST /api/locations`
- Body:
  - `{ "building": "A", "row": "1", "shelf": "3" }`
- Várható: 200
- Mentsd el: `LOCATION_ID`

### 4.3) Product létrehozás (a fenti 2 ID-val)
- `POST /api/products`
- Body:
  - `{ "name": "Póló", "description": "Opcionális", "category_id": CATEGORY_ID, "location_id": LOCATION_ID, "quantity": 10, "size": "M" }`
- Várható: 200
- Mentsd el: `PRODUCT_ID`

### 4.4) Update (fontos!)
A validáció miatt az UPDATE-hez is add meg a kötelező mezőket.

- `PUT /api/products/PRODUCT_ID`
- Body (teljes):
  - `{ "name": "Póló v2", "description": "friss", "category_id": CATEGORY_ID, "location_id": LOCATION_ID, "quantity": 12, "size": "L" }`
- Várható: 200

### 4.5) Admin NEM törölhet
Ezeknek 403-at kell adniuk adminnak:
- `DELETE /api/products/PRODUCT_ID`
- `DELETE /api/categories/CATEGORY_ID`
- `DELETE /api/locations/LOCATION_ID`

### 4.6) Admin user-lista
- `GET /api/users`
- Body: nincs
- Várható: 200 (admin láthatja)

De ezek 403 adminnak (csak super):
- `PUT /api/users/{user}/make-admin`
- `PUT /api/users/{user}/remove-admin`
- `DELETE /api/users/{user}`
- `PUT /api/users/{user}/password`
- `PUT /api/users/{user}/profile`

## 5) Super admin teszt (TOKEN_SUPER)

### 5.1) Admin jog adás/elvétel
- `GET /api/users` → nézd ki egy user `id`-ját, pl. `USER_ID`
- `PUT /api/users/USER_ID/make-admin` (body nincs) → 200
- `PUT /api/users/USER_ID/remove-admin` (body nincs) → 200

### 5.2) Más jelszó / profil módosítása (super)
- `PUT /api/users/USER_ID/password`
  - Body: `{ "password": "Aa1!aa!!", "password_confirmation": "Aa1!aa!!" }`
- `PUT /api/users/USER_ID/profile`
  - Body: `{ "city": "Pécs" }`

### 5.3) Törlések (super)
- `DELETE /api/products/PRODUCT_ID`
- `DELETE /api/categories/CATEGORY_ID`
- `DELETE /api/locations/LOCATION_ID`

Megjegyzés: a `super_admin` usert nem törölheted.
