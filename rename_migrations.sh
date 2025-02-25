#!/usr/bin/env bash

# rename_migrations.sh
# Script para renombrar las migraciones y forzar el orden correcto.
# Ajusta si alguno de los nombres no coincide con lo que tienes.

# Orden correcto que queremos:
# 1. roles
# 2. usuarios
# 3. salas
# 4. peliculas
# 5. funciones
# 6. butacas
# 7. reservas
# 8. pagos
# 9. compras
# 10. promociones

# 1) roles
mv database/migrations/2025_02_24_204142_create_roles_table.php \
   database/migrations/2025_02_24_204140_create_roles_table.php

# 2) usuarios
mv database/migrations/2025_02_24_204143_create_usuarios_table.php \
   database/migrations/2025_02_24_204141_create_usuarios_table.php

# 3) salas
mv database/migrations/2025_02_24_204144_create_salas_table.php \
   database/migrations/2025_02_24_204142_create_salas_table.php

# 4) peliculas
mv database/migrations/2025_02_24_204145_create_peliculas_table.php \
   database/migrations/2025_02_24_204143_create_peliculas_table.php

# 5) funciones
# Nota: Funciones también tiene 2025_02_24_204144, pero ahora
# salas se renombró a 204142, así que podemos dejar funciones en 204144
# o darle 204144 de manera definitiva:
mv database/migrations/2025_02_24_204144_create_funciones_table.php \
   database/migrations/2025_02_24_204144_create_funciones_table.php

# 6) butacas
mv database/migrations/2025_02_24_204146_create_butacas_table.php \
   database/migrations/2025_02_24_204145_create_butacas_table.php

# 7) reservas
mv database/migrations/2025_02_24_204148_create_reservas_table.php \
   database/migrations/2025_02_24_204146_create_reservas_table.php

# 8) pagos
mv database/migrations/2025_02_24_204149_create_pagos_table.php \
   database/migrations/2025_02_24_204147_create_pagos_table.php

# 9) compras
mv database/migrations/2025_02_24_204150_create_compras_table.php \
   database/migrations/2025_02_24_204148_create_compras_table.php

# 10) promociones
mv database/migrations/2025_02_24_204151_create_promociones_table.php \
   database/migrations/2025_02_24_204149_create_promociones_table.php

echo "¡Renombrado completado! Revisa la carpeta database/migrations."
